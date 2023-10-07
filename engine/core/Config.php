<?php

namespace Excore\Core\Core;

use Excore\Core\Helpers\Path;

class Config
{
    private static array $db;

    public function __construct(
        private  $path
    ) {
        self::$db = $this->load('db');
    }

    public static function init($path)
    {
        return new static($path);
    }

    public static function db()
    {
        return self::$db;
    }


    private function load($config)
    {
        return require_once $this->path . Path::SEPARATOR . $config . '.php';
    }
}
