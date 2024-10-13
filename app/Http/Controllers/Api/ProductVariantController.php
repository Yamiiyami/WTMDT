<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\ProductVariantService;
use Exception;
use Illuminate\Http\Request;

class ProductVariantController extends Controller
{
    protected $productVariantService;
    public function __construct(ProductVariantService $productVariantService)
    {
        $this->productVariantService = $productVariantService;
    }

    public function index(){
        $cates = $this->productVariantService->getAll();
        return response()->json($cates);
    }

    public function show($id){
        $cate = $this->productVariantService->getById($id);
        return response()->json($cate);
    }

    public function store(Request $request){

        try{
            if($this->productVariantService->create($request->all())){
                return response()->json(['message'=> 'tạo thành công'],200);
            }
            return response()->json(['message'=> 'tạo thất bại'],400);

        }catch(Exception $e){
            return response()->json(['error'=>$e->getMessage()],500);
        }
    }

    public function update($id,Request $request){
        try{
            if($this->productVariantService->update($id,$request->all())){
                return response()->json(['message'=> 'xửa thành công'],200);
            }
            return response()->json(['message'=> 'xửa thất bại'],400);

        }catch(Exception $e){
            return response()->json(['error'=>$e->getMessage()],500);
        }
    }

    public function destroy($id){
        try{
            if($this->productVariantService->delete($id)){
                return response()->json(['message'=> 'xoá thành công'],200);
            }
            return response()->json(['message'=> 'xoá thất bại'],400);

        }catch(Exception $e){
            return response()->json(['error'=>$e->getMessage()],500);
        }
    }
}
