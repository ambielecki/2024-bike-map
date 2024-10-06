<?php

use App\Http\Controllers\ApiAuthController;
use App\Http\Controllers\ApiUserController;
use App\Http\Controllers\RouteController;
use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [ApiAuthController::class, 'postRegister']);
Route::post('/login', [ApiAuthController::class, 'postLogin']);
Route::post('/request-password-reset', [ApiAuthController::class, 'postRequestPasswordReset']);
Route::post('/password-reset', [ApiAuthController::class, 'postResetPassword']);

if (app()->isLocal()) {
    Route::get('/test', [TestController::class, 'index']);
}

Route::group(['prefix' => 'routes'], function () {
    Route::get('/{id}', [RouteController::class, 'show']);
    Route::get('/', [RouteController::class, 'index']);

    Route::group(['middleware' => ['auth:api']], function () {
        Route::post('/', [RouteController::class, 'create']);
    });
});

Route::group(['middleware' => ['auth:api']], function () {
    Route::get('/user', [ApiUserController::class, 'getUser']);
    Route::post('/refresh', [ApiAuthController::class, 'postRefresh']);
    Route::post('/logout', [ApiAuthController::class, 'postLogout']);
});
