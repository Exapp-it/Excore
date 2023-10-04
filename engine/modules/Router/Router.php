<?php

namespace Excore\Core\Modules\Router;

use Excore\Core\Config\Path;
use Excore\Core\Modules\Http\Request;
use Excore\Core\Modules\View\View;


class Router
{

    protected $routes = [
        'GET' => [],
        'POST' => [],
    ];

    public function __construct(
        protected Request $request,
        protected View $view,
    ) {
        $this->buildRoute();
    }



    public function dispatch()
    {
        $route = $this->findRoute($this->request->uri(), $this->request->method());

        if (!$route) {
            $this->errorPage(404);
        }


        if (is_array($route->getAction())) {
            [$controller, $action] = $route->getAction();

            $controller = new $controller($this->request, $this->view);

            call_user_func([$controller, $action], []);
        } else {
            call_user_func($route->getAction());
        }
    }

    private function findRoute(string $uri, string $method): Route|false
    {
        foreach ($this->routes[$method] as $route) {
            if ($route->getUri() === $uri) {
                return $route;
            }
        }

        return false;
    }

    private function buildRoute()
    {
        $routes = $this->getRoutes();
        foreach ($routes as $route) {
            $this->routes[$route->getMethod()][$route->getUri()] = $route;
        }
    }

    /**
     * @return Route[]
     */
    private function getRoutes(): array
    {

        return include_once routesPath('routes');
    }

    private function errorPage($code)
    {
        http_response_code($code);
        require(Path::views() . "errors/{$code}.exc.php");
        exit;
    }
}
