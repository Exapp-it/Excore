<?php

namespace Excore\App;

use Excore\Core\Config\Path;
use Excore\Core\Modules\Router\Router;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;


abstract class App
{
    protected static string $mode;


    public static function init($mode): void
    {
        self::setMode($mode);

        if (self::getMode() === 'dev') {
            self::devMode();
        }
    }

    public static function run()
    {
        $uri = $_SERVER['REQUEST_URI'];
        Path::init();
        Router::init(['main', 'api']);
        Router::dispatch($uri);
    }


    private static function getMode(): string
    {
        return self::$mode;
    }

    private static function setMode(string $mode): void
    {
        self::$mode = $mode;
    }

    private static function devMode(): void
    {
        $whoops = new Run;
        $whoops->pushHandler(new PrettyPageHandler);
        $whoops->register();
    }
}
