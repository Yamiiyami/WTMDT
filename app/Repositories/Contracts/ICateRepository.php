<?php
namespace App\Repositories\Contracts;

interface ICateRepository {
    public function all($relations=[]);
    public function allParent();
    public function pluck(string $column, string $key = null);
    public function find($id,$relations=[]);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
}