<?php
namespace App\Repositories\Eloquent;

use App\Models\Category;
use App\Repositories\BaseRepository;
use App\Repositories\Contracts\ICateRepository;

class CateRepository extends BaseRepository implements ICateRepository{

    public function __construct(Category $model)
    {
        parent::__construct($model);
    }
    
    public function allParent(){
        return $this->model->with('children')->whereNull('parent_id')->get();
    }



}