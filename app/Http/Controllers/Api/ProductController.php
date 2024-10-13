<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\ProductService;
use Exception;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $productService;
    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index(){
        $cates = $this->productService->getAll();
        return response()->json($cates);
    }

    public function show($id){
        $cate = $this->productService->getById($id);
        return response()->json($cate);
    }

    public function store(Request $request){

        try{
            if($this->productService->create($request->all())){
                return response()->json(['message'=> 'tạo thành công'],200);
            }
            return response()->json(['message'=> 'tạo thất bại'],400);

        }catch(Exception $e){
            return response()->json(['error'=>$e->getMessage()],500);
        }
    }

    public function update($id,Request $request){
        try{
            if($this->productService->update($id,$request->all())){
                return response()->json(['message'=> 'xửa thành công'],200);
            }
            return response()->json(['message'=> 'xửa thất bại'],400);

        }catch(Exception $e){
            return response()->json(['error'=>$e->getMessage()],500);
        }
    }

    public function destroy($id){
        try{
            if($this->productService->delete($id)){
                return response()->json(['message'=> 'xoá thành công'],200);
            }
            return response()->json(['message'=> 'xoá thất bại'],400);

        }catch(Exception $e){
            return response()->json(['error'=>$e->getMessage()],500);
        }
    }

}
