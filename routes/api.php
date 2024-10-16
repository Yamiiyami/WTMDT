<?php

use App\Http\Controllers\Api\AttributeController;
use App\Http\Controllers\Api\AttributeValueController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CateController;
use App\Http\Controllers\Api\ImageController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ProductVariantController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

// Các route bảo vệ bằng JWT
Route::group(['middleware' => ['jwt.verify']], function() {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('me', [AuthController::class, 'me']);
    Route::post('refresh', [AuthController::class, 'refresh']);
});

Route::group([
    'prefix' => 'admin'
],function($route){

Route::get('/users', [UserController::class, 'index']); 
Route::get('/users/{id}', [UserController::class, 'show']); 
Route::post('/users', [UserController::class, 'store']); 
Route::put('/users/{id}', [UserController::class, 'update']);
Route::delete('/users/{id}', [UserController::class, 'destroy']); 

Route::post('/users/{id}/roles', [UserController::class, 'assignRole']); 
Route::delete('/users/{id}/roles', [UserController::class, 'removeRole']); 
Route::put('/users/{id}/roles/sync', [UserController::class, 'syncRoles']); 

});

Route::group([
    'prefix' => 'role'
],function($route){
    Route::get('getall',[RoleController::class,'index']);
    Route::get('getbyid/{id}',[RoleController::class,'show']);

    Route::post('create',[RoleController::class,'store']);
    Route::put('update/{id}',[RoleController::class,'update']);
    Route::delete('delete/{id}',[RoleController::class,'destroy']);
});

Route::group([
    'prefix' => 'cate'
],function($route){
    Route::get('getall',[CateController::class,'index']);
    Route::get('getcatenull',[CateController::class,'getAllcateNull']);
    Route::get('getbyid/{id}',[CateController::class,'show']);
    Route::post('create',[CateController::class,'store']);
    Route::put('update/{id}',[CateController::class,'update']);
    Route::delete('delete/{id}',[CateController::class,'destroy']);
});

Route::group([
    'prefix' => 'product'
],function($route){
    Route::get('getall',[ProductController::class,'index']);
    Route::get('getbyid/{id}',[ProductController::class,'show']);
    Route::get('getbycate/{id}',[ProductController::class,'getByIdCate']);

    Route::post('create',[ProductController::class,'store']);
    Route::put('update/{id}',[ProductController::class,'update']);
    Route::delete('delete/{id}',[ProductController::class,'destroy']);
});

Route::group([
    'prefix' => 'product-variant'
],function($route){
    Route::get('getall',[ProductVariantController::class,'index']);
    Route::get('getbyid/{id}',[ProductVariantController::class,'show']);
    Route::post('create',[ProductVariantController::class,'store']);
    Route::put('update/{id}',[ProductVariantController::class,'update']);
    Route::delete('delete/{id}',[ProductVariantController::class,'destroy']);
});

Route::group([
    'prefix' => 'attribute'
],function($route){
    Route::get('getall',[AttributeController::class,'index']);
    Route::get('getbyid/{id}',[AttributeController::class,'show']);
    Route::post('create',[AttributeController::class,'store']);
    Route::put('update/{id}',[AttributeController::class,'update']);
    Route::delete('delete/{id}',[AttributeController::class,'destroy']);
});

Route::group([
    'prefix' => 'attribute-value'
],function($route){
    Route::get('getall',[AttributeValueController::class,'index']);
    Route::get('getbyid/{id}',[AttributeValueController::class,'show']);
    Route::post('create',[AttributeValueController::class,'store']);
    Route::put('update/{id}',[AttributeValueController::class,'update']);
    Route::delete('delete/{id}',[AttributeValueController::class,'destroy']);
});

Route::group([
    'prefix' => 'image'
],function($route){
    Route::get('getall',[ImageController::class,'index']);
    Route::get('getbyid/{id}',[ImageController::class,'show']);
    Route::post('create',[ImageController::class,'store']);
    Route::post('update/{id}',[ImageController::class,'update']);
    Route::delete('delete/{id}',[ImageController::class,'destroy']);
});