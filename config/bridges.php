<?php


return [
    'default' => [
        'csrf' => \Excore\Core\Bridges\CsrfBridge::class,
    ],

    'app' => [
        'auth' => \Excore\App\Bridges\AuthBridge::class,
    ],
];
