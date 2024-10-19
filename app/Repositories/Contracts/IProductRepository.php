<?php
namespace App\Repositories\Contracts;

interface IProductRepository{
    public function all($relations=[]);
    public function paginate(int $perPage = 15, $relations=[]);
    public function search(array $columns, string $keyword,$relations=[] , $select=['*'] );
    public function find($id,$relations=[]);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
    public function whereIn($relations =[],string $column, array $values);
}
