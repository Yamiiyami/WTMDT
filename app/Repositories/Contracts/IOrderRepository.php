<?php
namespace App\Repositories\Contracts;

interface IOrderRepository {
    public function all($relations=[]);
    public function find($id,$relations=[]);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
    public function findAllBy(string $column, $value,$relations=[],$columns=['*']);
    public function deleteWhere(array $conditions);
    public function findWithWhere(array $conditions);
}