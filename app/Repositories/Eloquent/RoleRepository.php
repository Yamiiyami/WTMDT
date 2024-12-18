<?php
namespace App\Repositories\Eloquent;

use App\Repositories\BaseRepository;
use App\Repositories\Contracts\IRoleRepository;
use Spatie\Permission\Models\Role;

class RoleRepository extends BaseRepository implements IRoleRepository {
    public function __construct(Role $model)
    {
        parent::__construct($model);
    }
    
}