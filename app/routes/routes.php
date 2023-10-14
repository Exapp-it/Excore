<?php

use Excore\App\Controllers\Auth\DashboardController;
use Excore\App\Controllers\Auth\LoginController;
use Excore\App\Controllers\Auth\RegisterController;
use Excore\App\Controllers\MainController;
use Excore\Core\Modules\Router\Route;


return [
    Route::get('/', [MainController::class, 'index']),

    // Auth
    Route::get('login', [LoginController::class, 'index']),
    Route::post('login', [LoginController::class, 'handler']),
    Route::get('register', [RegisterController::class, 'index']),
    Route::post('register', [RegisterController::class, 'handler']),

    // Dashboard
    Route::get('dashboard', [DashboardController::class, 'index']),
];
