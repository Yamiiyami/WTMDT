<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\RoleeService;
use Illuminate\Http\Request;

class RoleeController extends Controller
{
    protected $roleService;
    public function __construct(RoleeService $roleService)
    {
        $this->roleService = $roleService;
    }

    public function index()
    {
        $roles = $this->roleService->getAll();
        return response()->json($roles);
    }

    public function show($id)
    {
        $role = $this->roleService->getById($id);
        if ($role) {
            return response()->json($role);
        }
        return response()->json(['message' => 'Role khôn tìm thấy'], 404);
    }

    public function store(Request $request)
    {
        try {
            $role = $this->roleService->create($request->all());
            return response()->json($role, 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $updated = $this->roleService->update($id, $request->all());
            if ($updated) {
                return response()->json(['message' => 'Role xửa thành công']);
            }
            return response()->json(['message' => 'Role không tìm thấy'], 404);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    public function destroy($id)
    {
        $deleted = $this->roleService->delete($id);
        if ($deleted) {
            return response()->json(['message' => 'Role xoá thành công']);
        }
        return response()->json(['message' => 'Role không tìm thấy'], 404);
    }
}
