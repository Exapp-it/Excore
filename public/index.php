<?php
use Excore\App\App;

require(dirname(__DIR__) . '/vendor/autoload.php');






App::init('dev');
App::run();
