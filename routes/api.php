<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CateController;
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
// User CRUD
Route::get('/users', [UserController::class, 'index']); 
Route::get('/users/{id}', [UserController::class, 'show']); 
Route::post('/users', [UserController::class, 'store']); 
Route::put('/users/{id}', [UserController::class, 'update']);
Route::delete('/users/{id}', [UserController::class, 'destroy']); 
// Role Management
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

