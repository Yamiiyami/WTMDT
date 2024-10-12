<?php
namespace App\Repositories\Eloquent;

use App\Models\User;
use App\Repositories\BaseRepository;
use App\Repositories\Contracts\IUserRepository;

class UserRepository extends BaseRepository implements IUserRepository{

    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    // function assignRoleToUser($userId, $role){
    //     $user = $this->find($userId); 
    //     if ($user) {
    //         return $user->assignRole($role);
    //     }
    //     return false;
    // }
    
    // function removeRoleFromUser($userId, $role){
    //     $user = $this->find($userId);
    //     if ($user) {
    //         try {
    //             $user->removeRole($role);
    //             return true;
    //         } catch (\Exception $e) {
    //             Log::error('Lỗi khi loại bỏ vai trò khỏi người dùng', [
    //                 'user_id' => $userId,
    //                 'role' => $role,
    //                 'error' => $e->getMessage(),
    //             ]);
    //             return false;
    //         }
    //     }
    //     Log::warning('Người dùng không tồn tại khi loại bỏ vai trò', ['user_id' => $userId]);
    //     return false;
    // }
        
    // function syncRolesForUser($userId, array $roles){
    //     $user = $this->find($userId);
    //     if ($user) {
    //         DB::beginTransaction();
    //         try {
    //             $user->syncRoles($roles);
    //             DB::commit();
    //             return true;
    //         } catch (\Exception $e) {
    //             DB::rollback();
    //             Log::error('Lỗi khi đồng bộ vai trò cho người dùng', [
    //                 'user_id' => $userId,
    //                 'roles' => $roles,
    //                 'error' => $e->getMessage(),
    //             ]);
    //             return false;
    //         }
    //     }
    //     Log::warning('Người dùng không tồn tại khi đồng bộ vai trò', ['user_id' => $userId]);
    //     return false;
    // }

}