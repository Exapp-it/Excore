<?php

use Excore\App\App;
use Excore\Core\Core\Config;
use Excore\Core\Modules\Database\DB;
use Excore\Core\Modules\Database\QueryBuilder;


require(dirname(__DIR__) . '/vendor/autoload.php');



$app = new App('dev');
$app->run();
