<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\userRequest;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $userService;
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index(){
        try{
             $users = $this->userService->getAll();
             return response()->json(['users'=>$users]);
        }catch(Exception $e){
            return response()->json(['error'=>$e->getMessage()],500);
        }
        
    }

    public function show($id){
        try{
            $user = $this->userService->getById($id);
            return response()->json(['user'=>$user]);
       }catch(Exception $e){
           return response()->json(['message'=>$e->getMessage()],500);
       }
      
    }

    public function store(userRequest $request){
        try{
            $user = $request->validated();
            if($this->userService->create($user)){
                return response()->json(['message'=>'tạo thành công'],201);
            }
            return response()->json(['message'=>'tạo thất bại'],400);
        }catch(Exception $e){
            return response()->json(['error'=>$e->getMessage()],500);
        }
    }

    public function update($id,userRequest $request){
        try{
            $user = $request->validated();
            if($this->userService->update($id,$user)){
                return response()->json(['message'=>'sửa thành công'],201);
            }
            return response()->json(['message'=>'sửa thất bại'],400);
        }catch(Exception $e){
            return response()->json(['message'=>$e->getMessage()],500);
        }
    }

    public function destroy($id){
        try{
            
            if($this->userService->delete($id)){
                return response()->json(['message'=>'xoá thành công'],200);
            }
            return response()->json(['message'=>'không tìm thấy'],400);
        }catch(Exception $e){
            return response()->json(['message'=>$e->getMessage()],500);
        }
    }

    // POST /api/users/{id}/roles
    public function assignRole($id, Request $request)
    {
        try {
            $roles = $request->input('roles'); 
            if (!$roles) {
                return response()->json(['message' => 'yêu cầu roles'], 400);
            }

            $assigned = $this->userService->assignRoleToUser($id, $roles);
            if ($assigned) {
                return response()->json(['message' => 'Roles assigned successfully'], 200);
            }
            return response()->json(['message' => 'Role assignment failed'], 400);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function removeRole(int $id, Request $request)
    {
        try {
            $role = $request->input('role'); 
            if (!$role) {
                return response()->json(['message' => 'không có dữ liệu role'], 400);
            }

            $removed = $this->userService->removeRoleFromUser($id, $role);
            if ($removed) {
                return response()->json(['message' => 'xoá role thành công'], 200);
            }
            return response()->json(['message' => 'xoá role thất bại'], 400);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function syncRoles($id, Request $request)
    {
        try {
            $roles = $request->input('roles'); 
            if (!is_array($roles)) {
                return response()->json(['message' => 'roles phải là mảng'], 400);
            }

            $synced = $this->userService->syncRolesForUser($id, $roles);
            if ($synced) {
                return response()->json(['message' => 'roles được đồng bộ thành công'], 200);
            }
            return response()->json(['message' => 'roles được đồng bộ thất bại'], 400);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

}
