<?php
namespace App\Services;

use App\Repositories\Contracts\IAttributesRepository;
use App\Repositories\Contracts\IAttributeValueRepository;
use Exception;
use Illuminate\Support\Facades\DB;

class AttributeService {
    protected $attributeRepo;
    protected $attribuValueRepo;
    public function __construct(IAttributesRepository $attributeRepo, IAttributeValueRepository $attribuValueRepo)
    {
        $this->attributeRepo = $attributeRepo;
        $this->attribuValueRepo = $attribuValueRepo;
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

    public function addAttribute(array $data){
        DB::beginTransaction();
        try{
            $attribute = $this->attributeRepo->create(['name'=>$data['name']]);
            foreach($data['values'] as $value){
                $this->attribuValueRepo->create(['value' => $value['value'], 'attribute_id' => $attribute->id]);
            }

            DB::commit();
            return true;
        }catch(Exception $e){
            DB::rollBack();
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