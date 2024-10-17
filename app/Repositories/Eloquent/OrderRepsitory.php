<?php
namespace App\Repositories\Eloquent;

use App\Models\Order;
use App\Repositories\BaseRepository;
use App\Repositories\Contracts\IOrderRepository;

class OrderRepsitory extends BaseRepository implements IOrderRepository {

    public function __construct(Order $model)
    {
        parent::__construct($model);
    }
    

}