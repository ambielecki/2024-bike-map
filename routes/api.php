<?php

use App\Http\Controllers\RouteController;
use App\Http\Controllers\TestController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

if (app()->isLocal()) {
    Route::get('/test', [TestController::class, 'index']);
}

Route::group(['prefix' => 'routes'], function () {
    Route::get('/', [RouteController::class, 'index']);
    Route::post('/', [RouteController::class, 'create']);
});
