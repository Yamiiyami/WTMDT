<?php
namespace App\Repositories\Eloquent;

use App\Models\ProductVariant;
use App\Repositories\BaseRepository;
use App\Repositories\Contracts\IProductVariantRepository;

class ProductVariantRepository extends BaseRepository implements IProductVariantRepository{

    public function __construct(ProductVariant $model)
    {
        parent::__construct($model);
    }
    
    
}