<?php

namespace Excore\Core\Config;

class Path
{

    const SEPARATOR = DIRECTORY_SEPARATOR;

    private static string $app;
    private static string  $views;
    private static string $root;

    public static function init()
    {
        self::$root = $_SERVER['DOCUMENT_ROOT'];
        self::setApp(self::$root);
        self::setViews(self::app());
    }

    public static function app()
    {
        return self::$app;
    }

    private static function setApp($path)
    {
        self::$app = rtrim($path, self::SEPARATOR) . self::SEPARATOR . 'app';
    }

    public static function views()
    {
        return self::$views;
    }

    private static function setViews($path)
    {

        self::$views = $path . self::SEPARATOR . 'views';
    }
}
