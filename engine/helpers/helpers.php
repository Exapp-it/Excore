<?php

use Excore\Core\Config\Env;
use Excore\Core\Config\Path;




function routesPath($name)
{
    return Path::app() . "/routes/{$name}.php";
}


function env($key)
{
    return Env::get($key);
}
