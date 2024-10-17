<?php
namespace App\Services;

use App\Models\Order;
use App\Repositories\Contracts\ICartRepository;
use App\Repositories\Contracts\IOrderItemRepository;
use App\Repositories\Contracts\IOrderRepository;
use Exception;
use Illuminate\Support\Facades\DB;

class OrderService {

    protected $orderRepo;
    protected $cartItemService;
    protected $orderItemRepo;
    protected $cartRepo;
    public function __construct(IOrderRepository $orderRepo, CartItemService $cartItemService, IOrderItemRepository $orderItemRepo, ICartRepository $cartRepo)
    {
        $this->cartRepo = $cartRepo;
        $this->orderItemRepo = $orderItemRepo;
        $this->cartItemService = $cartItemService;
        $this->orderRepo = $orderRepo;
    }

    
    public function getAll(){
        return $this->orderRepo->all();
 
    }

    public function getById($id){
        return $this->orderRepo->find($id);
    }

    public function getByIdUser(){
        $user = auth()->user();
        if(!$user){
            throw new Exception('error : Invalid Credentials');
        }
        return $this->orderRepo->findAllBy('user_id',$user->id);
    }
    
    public function create(array $order){
        DB::beginTransaction();
        try{
            $user = auth()->user();
            if(!$user){
                throw new Exception('error : Invalid Credentials');
            }
            $cartitems = $this->cartItemService->getByIdUser();
            if(!$cartitems){
                throw new Exception('không có sản phẩm');
            }
            $totalprice = $cartitems->sum(function($cartitem){
                return $cartitem->quantity * $cartitem->price;
            });
            $data = [
                'user_id' => $user->id, 
                'total_amount' => $totalprice , 
                'payment_method' => 'tại quán', 
                'payment_status' => 'chưa thanh toán' , 
                'phone' => $order['phone'], 
                'address' => $order['address'], 
                'note' => $order['note']
            ];
            $order = $this->orderRepo->create($data);
            if(!$order){
                throw new Exception('tạo order không thành công');
            }

            foreach($cartitems as $cartitem){
                $orderitem = [
                    'order_id' => $order->id, 
                    'product_variant_id' => $cartitem->product_variant_id, 
                    'quantity' => $cartitem->quantity,
                    'price' => $cartitem->price
                ];
                if(!$this->orderItemRepo->create($orderitem)){
                    throw new Exception('tạo order-sp không thành công');
                }
            }
            if(!$this->cartRepo->delete($cartitems->id)){
                throw new Exception('xoá cart không thành công');
            }

            DB::commit();
            return true;
            
            
        }catch(Exception $e){
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
    }

    public function update($id,array $order){
        try{
            $user = auth()->user();
            if(!$user){
                throw new Exception('error : Invalid Credentials');
            }

            $data = [
                'phone' => $order['phone'], 
                'address' => $order['address'], 
                'note' => $order['note']
            ];

            if($this->orderRepo->update($id,$data)){
                return true;
            }
            throw new Exception('không tìm thấy order');
        }catch(Exception $e){
            throw new Exception($e->getMessage());
        }
    }

    public function delete($id){
        try{
            $user = auth()->user();
            if($this->orderRepo->deleteWhere(['user_id' => $user->id, 'id' => $id])){
                return true;
            }
            return false;
        }catch(Exception $e){
            throw new Exception($e->getMessage());
        }
    }   

}