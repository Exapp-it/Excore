<?php

use Excore\App\Controllers\Auth\LoginController;
use Excore\App\Controllers\Auth\RegisterController;
use Excore\App\Controllers\Dashboard\DashboardController;
use Excore\App\Controllers\MainController;
use Excore\Core\Modules\Router\Route;


return [
    Route::get('/', [MainController::class, 'index']),

    // Auth
    Route::get('login', [LoginController::class, 'index'])->bridge('guest'),
    Route::post('login', [LoginController::class, 'store'])->bridge('guest'),
    Route::get('register', [RegisterController::class, 'index'])->bridge('guest'),
    Route::post('register', [RegisterController::class, 'store'])->bridge('guest'),

    // Dashboard
    Route::get('dashboard', [DashboardController::class, 'index'])->bridge('auth'),
    Route::get('logout', [LoginController::class, 'logout'])->bridge('auth'),


    Route::get('test', function() {
        dd(auth()->user());
    }),
];
