<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Image\imagerequest;
use App\Services\ImageService;
use Exception;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    protected $imageService;

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

    public function index(){
        $cates = $this->imageService->getAll();
        return response()->json(['cate'=>$cates],200);
    }

    public function show($id){
        $cate = $this->imageService->getById($id);
        return response()->json($cate);
    }

    public function store(Request $request){
        try{
            if (!$request->hasFile('image')) {
                return response()->json(['message' => 'không tìm thấy ảnh trong yêu cầu'], 400);
            }
            if($this->imageService->create($request->input('id'),$request->input('idVariant'),$request->file('image'))){
                return response()->json(['message'=> 'tạo thành công'],200);
            }
            return response()->json(['message'=> 'tạo thất bại'],400);

        }catch(Exception $e){
            return response()->json(['error'=>$e->getMessage()],500);
        }
    }

    public function update($id,imagerequest $request){
        try{
            $request->validated();
            if (!$request->hasFile('image')) {
                return response()->json(['message' => 'không tìm thấy ảnh trong yêu cầu'], 400);
            }
            $image = $request->file('image');
            if($this->imageService->update($id,$image)){
                return response()->json(['message'=> 'xửa thành công'],200);
            }
            return response()->json(['message'=> 'xửa thất bại'],400);

        }catch(Exception $e){
            return response()->json(['error'=>$e->getMessage()],500);
        }
    }

    public function destroy($id){
        try{
            if($this->imageService->delete($id)){
                return response()->json(['message'=> 'xoá thành công'],200);
            }
            return response()->json(['message'=> 'xoá thất bại'],400);

        }catch(Exception $e){
            return response()->json(['error'=>$e->getMessage()],500);
        }
    }

}
