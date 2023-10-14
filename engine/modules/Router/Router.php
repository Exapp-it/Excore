<?php

namespace Excore\Core\Modules\Router;

use Excore\Core\Core\Config;
use Excore\Core\Helpers\Hash;
use Excore\Core\Helpers\Path;
use Excore\Core\Modules\Http\Request;
use Excore\Core\Modules\Http\Response;
use Excore\Core\Modules\Session\Session;
use Excore\Core\Modules\View\View;


class Router
{

    protected $routes = [
        'GET' => [],
        'POST' => [],
    ];

    protected array $bridges;

    public function __construct(
        protected Request $request,
        protected Response $response,
        protected Session $session,
        protected View $view,
    ) {
        $this->buildRoute();
        $this->bridges = $this->getBridges();
    }


    public static function init(Request $request, Response $response, Session $session,  View $view)
    {
        return new static($request, $response, $session, $view);
    }


    public function dispatch()
    {
        $route = $this->findRoute($this->request->uri(), $this->request->method());

        if (!$route) {
            View::errorPage(404);
        }

        if ($this->bridges) {
            $nextHandler = null;

            foreach ($this->bridges as $class) {
                $bridge = new $class();
                $bridge->handler($this->request, $this->response, $nextHandler);
                $nextHandler = $bridge;
            }
        }


        if (is_array($route->getAction())) {
            [$controller, $action] = $route->getAction();
            $controller = new $controller($this->request, $this->response, $this->session,  $this->view);
            call_user_func([$controller, $action]);
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

    private function getBridges(): array
    {

        return Config::bridges()['default'];
    }
}
