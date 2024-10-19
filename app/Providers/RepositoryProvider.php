<?php

namespace App\Providers;

use App\Repositories\Contracts\IAttributesRepository;
use App\Repositories\Contracts\IAttributeValueRepository;
use App\Repositories\Contracts\ICartItemsRepository;
use App\Repositories\Contracts\ICartRepository;
use App\Repositories\Contracts\ICateRepository;
use App\Repositories\Contracts\IImageRepository;
use App\Repositories\Contracts\IOrderItemRepository;
use App\Repositories\Contracts\IOrderRepository;
use App\Repositories\Contracts\IProductRepository;
use App\Repositories\Contracts\IProductVariantRepository;
use app\Repositories\Contracts\IRoleRepository;
use App\Repositories\Contracts\IUserRepository;
use App\Repositories\Contracts\IVariantAttributeRepository;
use App\Repositories\Eloquent\AttributesRepository;
use App\Repositories\Eloquent\AttributeValueRepository;
use App\Repositories\Eloquent\CartItemRepository;
use App\Repositories\Eloquent\CartRepository;
use App\Repositories\Eloquent\CateRepository;
use App\Repositories\Eloquent\ImageRepository;
use App\Repositories\Eloquent\OrderItemRepository;
use App\Repositories\Eloquent\OrderRepsitory;
use App\Repositories\Eloquent\ProductRepository;
use App\Repositories\Eloquent\ProductVariantRepository;
use app\Repositories\Eloquent\RoleRepository;
use App\Repositories\Eloquent\UserRepository;
use App\Repositories\Eloquent\VariantAttributeRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryProvider extends ServiceProvider
{

    public function register()
    {
        $this->app->bind(IUserRepository::class,UserRepository::class);
        $this->app->bind(IRoleRepository::class,RoleRepository::class);

        $this->app->bind(ICateRepository::class,CateRepository::class);
        $this->app->bind(IProductRepository::class,ProductRepository::class);
        $this->app->bind(IProductVariantRepository::class,ProductVariantRepository::class);
        $this->app->bind(IAttributesRepository::class,AttributesRepository::class);
        $this->app->bind(IAttributeValueRepository::class,AttributeValueRepository::class);
        $this->app->bind(IImageRepository::class,ImageRepository::class);

        $this->app->bind(ICartRepository::class,CartRepository::class);
        $this->app->bind(ICartItemsRepository::class,CartItemRepository::class);

        $this->app->bind(IOrderRepository::class,OrderRepsitory::class);
        $this->app->bind(IOrderItemRepository::class,OrderItemRepository::class);
        $this->app->bind(IVariantAttributeRepository::class,VariantAttributeRepository::class);


    }
    

    public function boot()
    {
        //
    }
}
