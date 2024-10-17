<?php
namespace App\Services;

use App\Repositories\Contracts\ICartRepository;
use Exception;
use Illuminate\Support\Facades\Auth;

class CartService {
    
    protected $cartRepo;
    public function __construct(ICartRepository $cartRepo)
    {
        $this->cartRepo = $cartRepo;
    }

    public function getAll()
    {
        return $this->cartRepo->all();
    }

    public function getById($id)
    {
        return $this->cartRepo->find($id);
    }

    public function getByIdUser(){
        $user = auth()->user();
        return $this->cartRepo->find($user->id);
    }

    public function create($userId)
    {
        try {

            return $this->cartRepo->create(['user_id'=>$userId]);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function update($id, array $cart)
    {
        try {

            return $this->cartRepo->update($id, $cart);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            return $this->cartRepo->delete($id);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }


}