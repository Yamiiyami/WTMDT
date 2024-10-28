<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory,HasRoles;
    protected $fillable = ['name','email','password','phone','status',];
    protected $appends = ['ten']; // Thêm 'ten' vào JSON trả về
    protected $hidden = ['password','name'];

    // Accessor cho 'ten' lấy giá trị từ 'name'
    public function getTenAttribute()
    {
        return $this->attributes['name'];
    }
    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

}
