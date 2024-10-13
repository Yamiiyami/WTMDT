<?php
namespace App\Repositories\Contracts;

interface IProductVariantRepository{
    public function all($relations=[]);
    public function find($id,$relations=[]);
    public function findAllBy(string $column, $value,$relations=[],$columns=['*']);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);

}


