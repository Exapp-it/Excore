<?php

namespace Excore\Core\Helpers;

use Excore\Core\Modules\Http\Request;

class Path
{

    const SEPARATOR = DIRECTORY_SEPARATOR;

    private static string $root;
    private static string $app;
    private static string  $views;
    private static string  $layouts;
    private static string  $components;
    private static string  $config;

    public function __construct(Request $request)
    {
        self::$root = dirname($request->server('DOCUMENT_ROOT'));
        self::$app = rtrim(self::$root, self::SEPARATOR) . self::SEPARATOR . 'app';
        self::$views = self::$app . self::SEPARATOR . 'views' . self::SEPARATOR;
        self::$layouts = self::$views . 'layouts' . self::SEPARATOR;
        self::$components = self::$views . 'components' . self::SEPARATOR;
        self::$config = self::$root . self::SEPARATOR . 'config';
    }

    public static function init(Request $request)
    {
        return new static($request);
    }

    public static function root()
    {
        return self::$root;
    }


    public static function app()
    {
        return self::$app;
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

    public static function config()
    {
        return self::$config;
    }
}
