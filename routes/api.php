<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthorizationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\BatchController;
use App\Http\Controllers\OrderController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register', [AuthorizationController::class, 'userRegister']);
Route::post('/login', [AuthorizationController::class, 'login']);
Route::post('auth/verifyEmail', [AuthorizationController::class, 'verifyEmail']);


Route::prefix('user')->middleware('auth:sanctum')->group(function () {
    Route::put('{id}', [UserController::class, 'update']);
    Route::get('{id}', [UserController::class, 'getOneUser']);
    Route::post('changePassword', [UserController::class, 'changePassword']);
});

//Category Routes
Route::prefix('category')->middleware('auth:sanctum')->group(function () {
    Route::get('/', [CategoryController::class, 'index']);
    Route::post('/', [CategoryController::class, 'store']);
    Route::put('{id}', [CategoryController::class, 'update']);
    Route::get('{id}', [CategoryController::class, 'getOneCategory']);
    Route::delete('{id}', [CategoryController::class, 'destroy']);
});

Route::prefix('product')->middleware('auth:sanctum')->group(function () {
    Route::get('/', [ProductController::class, 'index']);
    Route::post('/', [ProductController::class, 'store']);
    Route::put('{id}', [ProductController::class, 'update']);
    Route::get('{id}', [ProductController::class, 'getOneProduct']);
    Route::delete('{id}', [ProductController::class, 'destroy']);
});

Route::prefix('vendor')->middleware('auth:sanctum')->group(function () {
    Route::get('/', [VendorController::class, 'index']);
    Route::post('/', [VendorController::class, 'store']);
    Route::put('{id}', [VendorController::class, 'update']);
    Route::get('{id}', [VendorController::class, 'getOneVendor']);
    Route::delete('{id}', [VendorController::class, 'destroy']);
});

Route::prefix('batch')->middleware('auth:sanctum')->group(function () {
    Route::get('/', [BatchController::class, 'index']);
    Route::post('/', [BatchController::class, 'store']);
    Route::put('{id}', [BatchController::class, 'update']);
    Route::get('{id}', [BatchController::class, 'getOneBatch']);
    Route::delete('{id}', [BatchController::class, 'destroy']);
});

Route::prefix('order')->middleware('auth:sanctum')->group(function () {
    Route::get('/', [OrderController::class, 'index']);
    Route::post('/', [OrderController::class, 'store']);
    Route::put('{id}', [BatchController::class, 'update']);
    //Route::get('{id}', [BatchController::class, 'getOneBatch']);
    Route::delete('{id}', [BatchController::class, 'destroy']);
});



