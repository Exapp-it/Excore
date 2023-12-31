<?php

namespace Excore\App;

use Excore\App\Dependencies;
use Excore\Core\Core\CoreApp;
use Excore\Core\Core\Container;
use Excore\Core\Modules\Database\DB;
use Excore\Core\Modules\Http\Request;
use Excore\Core\Modules\Http\Response;
use Excore\Core\Modules\Router\Router;
use Excore\Core\Modules\Session\Session;
use Excore\Core\Modules\View\View;


class App extends CoreApp
{

    public readonly Container $container;
    public readonly DB $db;
    public readonly Request $request;
    public readonly Response $response;
    public readonly Session $session;
    public readonly View $view;
    public readonly Router $router;

    public  function __construct()
    {
        $this->container = Container::getInstance();
        $modulesInjecition = new Modules($this->container);
        $modulesInjecition->bind()->use();
    }

    public function run()
    {

        if ($this->environment() === 'develop') {
            $this->development();
        }

        $this->useHelpersFunctions();
        $this->container->resolve('Path');
        $this->container->resolve('Env');
        $this->container->resolve('Config');
        $this->container->resolve('Assets');
        $this->container->resolve('Hash');
        $this->db = $this->container->resolve('DB');
        $this->request = $this->container->resolve('Request');
        $this->session = $this->container->resolve('Session');
        $this->view = $this->container->resolve('View');
        $this->router = $this->container->resolve('Router');
        $this->router->dispatch();
    }
}
