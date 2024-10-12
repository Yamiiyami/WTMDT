<?php

namespace App\Providers;

use app\Repositories\Contracts\IRoleRepository;
use App\Repositories\Contracts\IUserRepository;
use app\Repositories\Eloquent\RoleRepository;
use App\Repositories\Eloquent\UserRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryProvider extends ServiceProvider
{

    public function register()
    {
        $this->app->bind(IUserRepository::class,UserRepository::class);
        $this->app->bind(IRoleRepository::class,RoleRepository::class);

    }

    public function boot()
    {
        //
    }
}
