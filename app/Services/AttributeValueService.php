<?php
namespace App\Services;

use App\Repositories\Contracts\IAttributeValueRepository;
use Exception;

class AttributeValueService{

    protected $attributeValueRepo;

    public function __construct(IAttributeValueRepository $attributeValueRepo)
    {
        $this->attributeValueRepo = $attributeValueRepo;
    }

    public function getAll(){
        return $this->attributeValueRepo->all(['variants']);
    }

    public function getById($id){
        return $this->attributeValueRepo->find($id,['variants']);
    }

    public function create(array $data){
        try{
            return $this->attributeValueRepo->create($data);
        }catch(Exception $e){
            throw new Exception($e->getMessage());
        }
    }

    public function update($id,array $data){
        try{
            return $this->attributeValueRepo->update($id,$data);
        }catch(Exception $e){
            throw new Exception($e->getMessage());
        }
    }

    public function delete($id){
        try{
            return $this->attributeValueRepo->delete($id);
        }catch(Exception $e){
            throw new Exception($e->getMessage());
        }
    }

}