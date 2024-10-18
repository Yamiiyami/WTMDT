<?php
namespace App\Services;

use App\Repositories\Contracts\IImageRepository;
use Exception;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ImageService {

    protected $imageRepo;
    public function __construct(IImageRepository $imageRepo)
    {
        $this->imageRepo = $imageRepo;
    }

    public function getAll(){
        return $this->imageRepo->all();
 
    }

    public function getById($id){
        return $this->imageRepo->find($id);

    }

    public function create($id, UploadedFile $picture){
        DB::beginTransaction();
        try{
            $originalName = $picture->getClientOriginalName();
            $imagePath = $picture->store('images','public');
            if(!$imagePath){
                throw new Exception('khong them dc anh !!!');
            }
            $image = [
                'product_id' => $id,
                'file_name' => $originalName,
                'url' => $imagePath,
                    
            ];
            if(!$this->imageRepo->create($image)){
                throw new Exception('khong them dc anh !!');
            }
            DB::commit();
            return true;
            
        }catch(Exception $e){
            DB::rollBack( );
            throw new Exception($e->getMessage());
        }
    }

    public function update($id,UploadedFile $pictures){
        try{
            $picture = $this->imageRepo->find($id);
            if(!$picture){
                return false;
            }
            $oldImagePath  = $picture['url'];
            if($oldImagePath && Storage::disk('public')->exists($oldImagePath)){
                Storage::disk('public')->delete($oldImagePath);
            }
            $originalName = $pictures->getClientOriginalName();
            $imagePath = $pictures->store('images','public');

            $image = [
                'file_name' => $originalName,
                'url' => $imagePath,
            ];
            if($this->imageRepo->update($id,$image)){
                return true;
            }
            return false;
        }catch(Exception $e){
            throw new Exception($e->getMessage());
        }
    }

    public function delete($id){
        try{
            $image = $this->imageRepo->find($id);
            if($image['url'] && Storage::disk('public')->exists($image['url'])){
                Storage::disk('public')->delete($image['url']);
            }
            if($this->imageRepo->delete($id)){
                return true;
            }
            return false;
        }catch(Exception $e){
            throw new Exception($e->getMessage());
        }
    }   
    

}

