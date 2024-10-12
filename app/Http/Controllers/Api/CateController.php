<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\CateService;
use Exception;
use Illuminate\Http\Request;

class CateController extends Controller
{
    
    protected $cateService;
    public function __construct(CateService $cateService)
    {
        $this->cateService = $cateService;
    }

    public function index(){
        $cates = $this->cateService->getAll();
        return response()->json($cates);
    }

    public function show($id){
        $cate = $this->cateService->getById($id);
        return response()->json($cate);
    }

    public function getAllcateNull(){
        $cates = $this->cateService->getAllCate();
        return response()->json($cates);
    }

    public function store(Request $request){

        try{
            if($this->cateService->create($request->all())){
                return response()->json(['message'=> 'tạo thành công'],200);
            }
            return response()->json(['message'=> 'tạo thất bại'],400);

        }catch(Exception $e){
            return response()->json(['error'=>$e->getMessage()],500);
        }
    }

    public function update($id,Request $request){
        try{
            if($this->cateService->update($id,$request->all())){
                return response()->json(['message'=> 'xửa thành công'],200);
            }
            return response()->json(['message'=> 'xửa thất bại'],400);

        }catch(Exception $e){
            return response()->json(['error'=>$e->getMessage()],500);
        }
    }

    public function destroy($id){
        try{
            if($this->cateService->delete($id)){
                return response()->json(['message'=> 'xoá thành công'],200);
            }
            return response()->json(['message'=> 'xoá thất bại'],400);

        }catch(Exception $e){
            return response()->json(['error'=>$e->getMessage()],500);
        }
    }

}
