<?php

namespace Excore\Core\Helpers;

use Excore\Core\Modules\Http\Request;

class Path
{
    const SEPARATOR = DIRECTORY_SEPARATOR;

    private const ROOT = 'DOCUMENT_ROOT';
    private const APP = 'app';
    private const VIEWS = 'views';
    private const LAYOUTS = 'layouts';
    private const COMPONENTS = 'components';
    private const CONFIG = 'config';

    private static string $root;
    private static string $app;
    private static string $views;
    private static string $layouts;
    private static string $components;
    private static string $config;

    private function __construct(Request $request)
    {
        self::$root = $request->server(self::ROOT);
        self::$app = rtrim(self::$root, self::SEPARATOR) . self::SEPARATOR . self::APP;
        self::$views = self::$app . self::SEPARATOR . self::VIEWS . self::SEPARATOR;
        self::$layouts = self::$views . self::LAYOUTS . self::SEPARATOR;
        self::$components = self::$views . self::COMPONENTS . self::SEPARATOR;
        self::$config = self::$root . self::SEPARATOR . self::CONFIG;
    }

    public static function init()
    {
        return new static(Request::init());
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
// Path, Env, Config, Assets, и Hash