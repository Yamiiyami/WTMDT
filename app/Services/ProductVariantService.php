<?php
namespace App\Services;

use App\Repositories\Eloquent\ProductVariantRepository;
use Exception;

class ProductVariantService{
    protected $productVariantRepo;
    public function __construct(ProductVariantRepository $productVariantRepo)
    {
        $this->productVariantRepo = $productVariantRepo;
    }

    public function getAll(){
        return $this->productVariantRepo->all(['attributes']);

    }

    public function getById($id){
        return $this->productVariantRepo->find($id,['attributes']);

    }

    public function create(array $data){
        try{
            return $this->productVariantRepo->create($data);
        }catch(Exception $e){
            throw new Exception($e->getMessage());
        }
    }

    public function update($id,array $data){
        try{
            return $this->productVariantRepo->update($id,$data);
        }catch(Exception $e){
            throw new Exception($e->getMessage());
        }
    }

    public function delete($id){
        try{
            return $this->productVariantRepo->delete($id);
        }catch(Exception $e){
            throw new Exception($e->getMessage());
        }
    }


}