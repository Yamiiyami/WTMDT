<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class role_permission extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //rết cache
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            // Quản Lý Người Dùng
            'view users', 'create users', 'edit users', 'delete users', 'assign roles',
            // Quản Lý Sản Phẩm
            'view products', 'create products', 'edit products', 'delete products', 'publish products',
            // Quản Lý Danh Mục Sản Phẩm
            'view categories', 'create categories', 'edit categories', 'delete categories',
            // Quản Lý Hình Ảnh
            'view images', 'upload images', 'edit images', 'delete images', 'assign images to products',
            // Quản Lý Giỏ Hàng
            'view carts', 'create carts', 'edit carts', 'delete carts',
            // Quản Lý Thông Tin Giỏ Hàng
            'view cart information', 'create cart information', 'edit cart information', 'delete cart information', 'update cart quantities',
            // Quản Lý Đơn Hàng
            'view orders', 'create orders', 'edit orders', 'delete orders', 'process orders', 

        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Tạo các roles và gán permissions

        // Admin
        $admin = Role::create(['name' => 'admin','guard_name' => 'api']);
        $admin->givePermissionTo(Permission::all());

        // Manager
        $managerPermissions = [
            'view users', 'create users', 'edit users', 'delete users',
            'assign roles', 
            'view products', 'create products', 'edit products', 'delete products', 'publish products',
            'view categories', 'create categories', 'edit categories', 'delete categories',
            'view images', 'upload images', 'edit images', 'delete images', 'assign images to products',
            'view carts', 'create carts', 'edit carts', 'delete carts',
            'view cart information', 'edit cart information', 'delete cart information', 'update cart quantities',
            'view orders', 'create orders', 'edit orders', 'delete orders', 'process orders', 
        ];
        $manager = Role::create(['name' => 'manager','guard_name' => 'api']);
        $manager->givePermissionTo($managerPermissions);

        // Staff
        $staffPermissions = [
            'view products', 'edit products',
            'view categories', 'edit categories',
            'view images', 'upload images', 'edit images',
            'view carts', 'edit carts',
            'view cart information', 'edit cart information', 'update cart quantities',
            'view orders', 'edit orders', 'process orders',
            
        ];
        $staff = Role::create(['name' => 'staff','guard_name' => 'api']);
        $staff->givePermissionTo($staffPermissions);

        // Customer
        $customerPermissions = [
            'view products',
            'view categories',
            'create orders', 'view orders',
            'create carts',
            'view cart information', 'create cart information', 'edit cart information', 'delete cart information' ,'update cart quantities',
        ];
        $customer = Role::create(['name' => 'customer','guard_name' => 'api']);
        $customer->givePermissionTo($customerPermissions);
    }
}
