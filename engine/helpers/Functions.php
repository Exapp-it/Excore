<?php

use Excore\Core\Helpers\Env;
use Excore\Core\Helpers\Path;




function routesPath($name)
{
    return Path::app() . "/routes/{$name}.php";
}


function env($key)
{
    return Env::get($key);
}
