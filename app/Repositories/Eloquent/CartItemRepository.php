<?php
namespace App\Repositories\Eloquent;

use App\Models\CartItem;
use App\Repositories\BaseRepository;
use App\Repositories\Contracts\ICartItemsRepository;
use App\Repositories\Contracts\ICartRepository;

class CartItemRepository extends BaseRepository implements ICartItemsRepository {

    public function __construct(CartItem $model)
    {
        parent::__construct($model);
    }

}