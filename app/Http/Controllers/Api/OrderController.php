<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\OrderService;
use Exception;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected $orderService;
    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    
    public function index(){
        $cates = $this->orderService->getAll();
        return response()->json($cates);
    }

    public function show($id){
        $cate = $this->orderService->getById($id);
        return response()->json($cate);
    }

    public function getByUser(){
        $cate = $this->orderService->getByIdUser();
        return response()->json($cate);
    }

    public function store(Request $request){
        try{
            if($this->orderService->create($request->all())){
                return response()->json(['message'=> 'tạo thành công'],200);
            }
            return response()->json(['message'=> 'tạo thất bại'],400);
            
        }catch(Exception $e){
            return response()->json(['error'=>$e->getMessage()],500);
        }
    }

    public function update($id,Request $request){
        try{
            if($this->orderService->update($id,$request->all())){
                return response()->json(['message'=> 'xửa thành công'],200);
            }
            return response()->json(['message'=> 'xửa thất bại'],400);

        }catch(Exception $e){
            return response()->json(['error'=>$e->getMessage()],500);
        }
    }

    public function destroy($id){
        try{
            if($this->orderService->delete($id)){
                return response()->json(['message'=> 'xoá thành công'],200);
            }
            return response()->json(['message'=> 'xoá thất bại'],400);

        }catch(Exception $e){
            return response()->json(['error'=>$e->getMessage()],500);
        }
    }

   
}
