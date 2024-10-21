<?php

namespace App\Services;

use App\Repositories\Contracts\ICartItemsRepository;
use App\Repositories\Contracts\ICartRepository;
use App\Repositories\Contracts\IProductRepository;
use App\Repositories\Contracts\IProductVariantRepository;
use Exception;

class CartItemService
{

    protected $cartItemRepo;
    protected $cartRepo;
    protected $prodVarianRepo;
    protected $producRepo;
    public function __construct(ICartItemsRepository $cartItemRepo, ICartRepository $cartRepo, IProductVariantRepository $prodVarianRepo, IProductRepository $producRepo)
    {
        $this->producRepo = $producRepo;
        $this->prodVarianRepo = $prodVarianRepo;
        $this->cartRepo = $cartRepo;
        $this->cartItemRepo = $cartItemRepo;
    }
    public function getAll()
    {
        return $this->cartItemRepo->all();
    }

    public function getById($id)
    {
        return $this->cartItemRepo->find($id);
    }

    public function getByIdUser()
    {
        $user = auth()->user();
        if (!$user) {
            throw new Exception('error : chưa đăng nhập hoặc đăng ký', 401);
        }
        $cart = $this->cartRepo->findBy('user_id', $user->id);
        return $this->cartItemRepo->findAllBy(
            'cart_id',
            $cart->id,
            [
                'productVariant:id,sku',
                'productVariant.images:id,file_name,url,is_primary,product_variant_id'
            ],
            ['id', 'cart_id', 'product_variant_id', 'quantity', 'price']
        );
    }

    public function create(array $cartItem)
    {
        try {

            $user = auth()->user();
            if (!$user) {
                throw new Exception('error : chưa đăng nhập', 401);
            }

            $cart = $this->cartRepo->findBy('user_id', $user->id);
            $checkcart = $this->cartItemRepo->findWithWhere(['cart_id' => $cart->id, 'product_variant_id' => $cartItem['product_variant_id']]);
            $product = $this->prodVarianRepo->find($cartItem['product_variant_id']);
            if( $cartItem['quantity'] > $product['quantity'] || $checkcart->quantity + $cartItem['quantity'] > $product['quantity']  ){
                throw new Exception('số lượng sản phẩm không đủ');
            }
            if ($checkcart) {
                $checkcart['quantity'] += $cartItem['quantity'];
                if ($this->cartItemRepo->update($checkcart->id, ['quantity' => $checkcart['quantity']])) {
                    return true;
                }
            } else {
                $productvar = $this->prodVarianRepo->find($cartItem['product_variant_id']);
                $product = $this->producRepo->find($productvar['product_id']);
                $cartitem = [
                    'cart_id' => $cart->id,
                    'product_variant_id' => $cartItem['product_variant_id'],
                    'quantity' => $cartItem['quantity'],
                    'price' => $product->price,
                ];
                if ($this->cartItemRepo->create($cartitem)) {
                    return true;
                }
            }

            return false;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function update($id, array $cartItem) {}

    public function delete($id)
    {
        try {
            $user = auth()->user();
            $cart = $this->cartRepo->findBy('user_id', $user->id);

            return $this->cartItemRepo->deleteWhere(['cart_id' => $cart->id, 'id' => $id]);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
