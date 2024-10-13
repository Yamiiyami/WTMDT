<?php
namespace App\Repositories\Eloquent;

use App\Models\AttributeValue;
use App\Repositories\BaseRepository;
use App\Repositories\Contracts\IAttributeValueRepository;

class AttributeValueRepository extends BaseRepository implements IAttributeValueRepository{

    public function __construct(AttributeValue $model)
    {
        parent::__construct($model);
    }

    

}