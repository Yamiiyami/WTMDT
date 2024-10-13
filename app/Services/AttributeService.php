<?php
namespace App\Services;

use App\Repositories\Contracts\IAttributesRepository;
use Exception;

class AttributeService {
    protected $attributeRepo;

    public function __construct(IAttributesRepository $attributeRepo)
    {
        $this->attributeRepo = $attributeRepo;
    }

    public function getAll(){
        return $this->attributeRepo->all(['values']);
    }

    public function getById($id){
        return $this->attributeRepo->find($id,['values']);
    }

    public function create(array $data){
        try{
            return $this->attributeRepo->create($data);
        }catch(Exception $e){
            throw new Exception($e->getMessage());
        }
    }

    public function update($id,array $data){
        try{
            return $this->attributeRepo->update($id,$data);
        }catch(Exception $e){
            throw new Exception($e->getMessage());
        }
    }

    public function delete($id){
        try{
            return $this->attributeRepo->delete($id);
        }catch(Exception $e){
            throw new Exception($e->getMessage());
        }
    }

}