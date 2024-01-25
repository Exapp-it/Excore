<?php

namespace Excore\Core\Core;

use Excore\Core\Helpers\Path;

class Config
{
    private static array $app;
    private static array $db;
    private static array $bridges;
    private static array $placeholders;

    public function __construct(
        private  $path
    ) {
        self::$app = $this->load('app');
        self::$db = $this->load('db');
        self::$bridges = $this->load('bridges');
        self::$placeholders = $this->load('placeholders');
    }

    public static function init($path)
    {
        return new static($path);
    }

    public static function app(String $name)
    {
        return self::$app[$name];
    }

    public static function db()
    {
        return self::$db;
    }

    public static function bridges()
    {
        return self::$bridges;
    }
    
    public static function placeholders()
    {
        return self::$placeholders;
    }


    private function load($config)
    {
        return include_once($this->path . Path::SEPARATOR . $config . '.php');
    }
}
