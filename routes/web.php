<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RouteController;
use App\Http\Controllers\TestController;

if (app()->isLocal()) {
    Route::get('/test', [TestController::class, 'index']);
}
