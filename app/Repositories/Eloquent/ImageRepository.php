<?php
namespace App\Repositories\Eloquent;

use App\Models\Image;
use App\Repositories\BaseRepository;
use App\Repositories\Contracts\IImageRepository;

class ImageRepository extends BaseRepository implements IImageRepository{

    public function __construct(Image $model)
    {
        parent::__construct($model);
    }

}
