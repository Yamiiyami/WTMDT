<?php
namespace App\Services;

use App\Repositories\Contracts\IUserRepository;
use Exception;
use Illuminate\Support\Facades\Hash;


class UserService {

    protected $userRepository;
    public function __construct(IUserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getAll()
    {
        return $this->userRepository->all('roles:id,name');
    }

    public function getById($id)
    {
        return $this->userRepository->find($id,'roles:id,name');
    }

    public function create(array $user)
    {
        try {
            if (isset($user['password'])) {
                $user['password'] = Hash::make($user['password']);
            }
            return $this->userRepository->create($user);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function update($id, array $user)
    {
        try {
            if (isset($user['password'])) {
                $user['password'] = Hash::make($user['password']);
            } else {
                unset($user['password']);
            }
            return $this->userRepository->update($id, $user);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
    

    public function delete($id)
    {
        try {
            return $this->userRepository->delete($id);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function assignRoleToUser($userId, $roles)
    {
        try {
            $user = $this->userRepository->find($userId);
            if (!$user) {
                throw new Exception('không tìm thấy user');
            }
            $user->assignRole($roles); 
            return true;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function removeRoleFromUser($userId, $role)
    {
        try {
            $user = $this->userRepository->find($userId);
            if (!$user) {
                throw new Exception('không tìm thấy user');
            }
            $user->removeRole($role);
            return true;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function syncRolesForUser($userId, array $roles)
    {
        try {
            $user = $this->userRepository->find($userId);
            if (!$user) {
                throw new Exception('không tìm thấy user');
            }
            $user->syncRoles($roles);
            return true;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}


