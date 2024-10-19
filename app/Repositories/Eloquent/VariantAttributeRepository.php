<?php
namespace App\Repositories\Eloquent;

use App\Models\VariantAttribute;
use App\Repositories\BaseRepository;
use App\Repositories\Contracts\IVariantAttributeRepository;

class VariantAttributeRepository extends BaseRepository implements IVariantAttributeRepository{

    public function __construct(VariantAttribute $model)
    {
        parent::__construct($model);   
    }
}

