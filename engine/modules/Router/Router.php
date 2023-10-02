<?php

namespace Excore\Core\Modules\Router;

use Excore\Core\Config\Path;


class Router
{

    protected static $routes = [
        'GET' => [],
        'POST' => [],
    ];

    public function __construct()
    {
    }

    public static function init(array $useRoutes)
    {
       $routes = self::getRoutes($useRoutes);

       dd($routes);
    }

    public static function dispatch($uri)
    {
        if (self::matches($uri)) {
            self::$routes[$uri]();
        } else {
            exit('No Route');
        }
    }


    private static function matches($uri)
    {
        if (array_key_exists($uri, self::$routes)) {
            return true;
        }
        return false;
    }

    /**
     * @return Route[]
     */

    private static function getRoutes($group)
    {
        $allRoutes = [];
        foreach ($group as $fileName) {
            $routes = (array) include_once Path::app() . "/routes/{$fileName}.php";
            foreach ($routes as $action) {
                $allRoutes[] = $action;
            }
        }
        return $allRoutes;
    }

    private static function routes()
    {
        return self::$routes;
    }

    private static function useController()
    {
    }
}
