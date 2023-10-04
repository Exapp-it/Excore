<?php

use Excore\App\App;

require(dirname(__DIR__) . '/vendor/autoload.php');

$app = new App('dev');
$app->run();
