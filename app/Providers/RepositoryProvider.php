<?php

namespace App\Providers;

use App\Repositories\Contracts\ICateRepository;
use App\Repositories\Contracts\IProductRepository;
use app\Repositories\Contracts\IRoleRepository;
use App\Repositories\Contracts\IUserRepository;
use App\Repositories\Eloquent\CateRepository;
use App\Repositories\Eloquent\ProductRepository;
use app\Repositories\Eloquent\RoleRepository;
use App\Repositories\Eloquent\UserRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryProvider extends ServiceProvider
{

    public function register()
    {
        $this->app->bind(IUserRepository::class,UserRepository::class);
        $this->app->bind(IRoleRepository::class,RoleRepository::class);
        $this->app->bind(ICateRepository::class,CateRepository::class);
        $this->app->bind(IProductRepository::class,ProductRepository::class);

    }

    public function boot()
    {
        //
    }
}
