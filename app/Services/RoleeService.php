<?php
namespace App\Services;

use App\Repositories\Contracts\IRoleRepository;
use Exception;

class RoleeService{
    protected $roleRepo;
    public function __construct(IRoleRepository $roleRepo)
    {
        $this->roleRepo = $roleRepo;
    }

    public function getAll()
    {
        return $this->roleRepo->all();
    }

    public function getById($id)
    {
        return $this->roleRepo->find($id);
    }

    public function create(array $user)
    {
        try {
            return $this->roleRepo->create($user);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function update($id, array $user)
    {
        try {
            return $this->roleRepo->update($id, $user);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            return $this->roleRepo->delete($id);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

}