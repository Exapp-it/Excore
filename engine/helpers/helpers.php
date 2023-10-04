<?php

use Excore\Core\Config\Path;




function routesPath($name)
{
    return Path::app() . "/routes/{$name}.php";
}
