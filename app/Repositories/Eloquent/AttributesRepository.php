<?php
namespace App\Repositories\Eloquent;

use App\Models\Attribute ;
use App\Repositories\BaseRepository;
use App\Repositories\Contracts\IAttributesRepository;


class AttributesRepository extends BaseRepository implements IAttributesRepository{

    public function __construct(Attribute $model)
    {
        parent::__construct($model);
    }

    

}