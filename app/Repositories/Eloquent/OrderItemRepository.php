<?php
namespace App\Repositories\Eloquent;

use App\Models\OrderItem;
use App\Repositories\BaseRepository;
use App\Repositories\Contracts\IOrderItemRepository;

class OrderItemRepository extends BaseRepository implements IOrderItemRepository{

    public function __construct(OrderItem $model)
    {
        parent::__construct($model);
    }
    
}