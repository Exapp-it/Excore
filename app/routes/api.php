<?php

$prefix = 'api';

return [
    "/{$prefix}" => function () {
        echo "Home Page API";
    },
    "/{$prefix}/about" => function () {
        echo "About Page API";
    },
];
