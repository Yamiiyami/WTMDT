<?php
namespace App\Repositories\Eloquent;

use App\Models\Cart;
use App\Repositories\BaseRepository;
use App\Repositories\Contracts\ICartRepository;

class CartRepository extends BaseRepository implements ICartRepository{

    public function __construct(Cart $model)
    {
        parent::__construct($model);
    }
    

}