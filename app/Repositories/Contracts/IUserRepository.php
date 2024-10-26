<?php
namespace App\Repositories\Contracts;

interface IUserRepository {
    public function all($relations=[],$colums =['*']);
    public function find($id,$relations=[]);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
    // public function assignRoleToUser($userId, $role);
    // public function removeRoleFromUser($userId, $role);
    // public function syncRolesForUser($userId, array $roles);
}
