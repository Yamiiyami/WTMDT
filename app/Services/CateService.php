<?php
namespace App\Services;

use App\Repositories\Contracts\ICateRepository;

use Exception;

class CateService{

    protected $cateRepo;
    public function __construct(ICateRepository $cateRepo)
    {
        $this->cateRepo = $cateRepo;
    }

    public function getAll(){
        return $this->cateRepo->all(['children']);
 
    }

    public function getById($id){
        return $this->cateRepo->find($id,['children']);

    }

    public function getAllCate(){
        return $this->cateRepo->allParent();
    }

    public function create(array $cate){
        try{
            if($this->cateRepo->create($cate)){
                return true;
            }
            return false;
        }catch(Exception $e){
            throw new Exception($e->getMessage());
        }
    }

    public function update($id,array $cate){
        try{
            if($this->cateRepo->update($id,$cate)){
                return true;
            }
            throw new Exception('không tìm thấy cate');
        }catch(Exception $e){
            throw new Exception($e->getMessage());
        }
    }

    public function delete($id){
        try{
            if($this->cateRepo->delete($id)){
                return true;
            }
            return false;
        }catch(Exception $e){
            throw new Exception($e->getMessage());
        }
    }   
    
}
