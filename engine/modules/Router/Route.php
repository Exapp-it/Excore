<?php

namespace Excore\Core\Modules\Router;


class Route
{

    private static string $uri;
    private static string $method;
    private static $action;

    public static function init($uri, $method, $action)
    {
        self::$uri = $uri;
        self::$method = $method;
        self::$action = $action;
    }

    public static function get($uri, $action)
    {
        return  static::init($uri, 'GET', $action);
    }

    public static function post($uri, $action)
    {
        return  static::init($uri, 'POST', $action);
    }

    public static function getMethod()
    {
        return self::$method;
    }

    public static function getAction()
    {
        return self::$action;
    }

    public static function getUri()
    {
        return self::$uri;
    }
}
