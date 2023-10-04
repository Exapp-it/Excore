<?php

namespace Excore\Core\Config;

use Excore\Core\Modules\Http\Request;

class Path
{

    const SEPARATOR = DIRECTORY_SEPARATOR;

    private static string $app;
    private static string  $views;
    private static string  $layouts;
    private static string  $components;
    private static string $root;

    public static function init(Request $request)
    {
        self::$root = $request->server('DOCUMENT_ROOT');
        self::setApp(self::$root);
        self::setViews(self::app());
        self::setLayout(self::views());
        self::setComponents(self::views());
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

    public static function layouts()
    {
        return self::$layouts;
    }

    public static function components()
    {
        return self::$components;
    }

    private static function setViews($path)
    {
        self::$views = $path . self::SEPARATOR . 'views' . self::SEPARATOR;
    }

    private static function setLayout($path)
    {

        self::$layouts = $path . 'layouts' . self::SEPARATOR;
    }

    private static function setComponents($path)
    {

        self::$components = $path . 'components' . self::SEPARATOR;
    }
}
