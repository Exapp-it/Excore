<?php

namespace Excore\Core\Modules\Router;

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

    public function __construct(
        protected Request $request,
        protected Response $response,
        protected Session $session,
        protected View $view,
    ) {
        $this->buildRoute();
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

        $this->checkCsrfToken();


        // $middleware = $route->getMiddleware();
        // $this->middlewareHandler->handle($middleware, function () use ($route) {
        if (is_array($route->getAction())) {
            [$controller, $action] = $route->getAction();

            $controller = new $controller($this->request, $this->response, $this->session,  $this->view);

            call_user_func([$controller, $action]);
        } else {
            call_user_func($route->getAction());
        }
        // });
    }

    protected function checkCsrfToken()
    {
        if ($this->request->method() === "POST") {
            $csrfToken = $this->request->getHeaders(Response::CSRF_HEADER_NAME);
            echo $csrfToken;
            if (true) {
                // $this->response->setStatus(419);
                return $this->response->sendJson([
                    'message' => 'Invalid CSRF token',
                    'errors' => ['text' => 'Invalid CSRF token'],
                ]);
            }
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
}
