<?php

use Excore\Core\Config\Path;
use Excore\Core\Modules\Router\Route;

return [

    Route::get('/', function () {
        require(Path::views() . Path::SEPARATOR . 'main/home.exc.php');
    }),

    Route::get('/about', function () {
        require(Path::views() . Path::SEPARATOR . 'main/about.exc.php');
    }),
];
