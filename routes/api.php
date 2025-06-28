<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthorizationController;
use App\Http\Controllers\UserController;

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


