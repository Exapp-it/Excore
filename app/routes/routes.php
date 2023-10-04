<?php

use Excore\App\Controllers\Auth\LoginController;
use Excore\App\Controllers\MainController;
use Excore\Core\Config\Path;
use Excore\Core\Modules\Router\Route;


return [
    Route::get('/', [MainController::class, 'index']),
    Route::get('login', [LoginController::class, 'index']),
];
