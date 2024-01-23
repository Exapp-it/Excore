<?php

namespace Excore\App;

use Excore\Core\Core\CoreApp;
use Excore\Core\Core\Container;
use Excore\Core\Modules\View\View;
use Excore\Core\Modules\Database\DB;
use Excore\Core\Modules\Http\Request;
use Excore\Core\Modules\Http\Response;
use Excore\Core\Modules\Router\Router;
use Excore\Core\Modules\Session\Session;

/**
 * Class App
 * @package Excore\App
 */
class App extends CoreApp
{
    /**
     * @var Container
     */
    private $container;

    /**
     * @var DB
     */
    private $db;

    /**
     * @var Request
     */
    private $request;

    /**
     * @var Response
     */
    private $response;

    /**
     * @var Session
     */
    private $session;

    /**
     * @var View
     */
    private $view;

    /**
     * @var Router
     */
    private $router;


    public function __construct()
    {
        $this->container = Container::getInstance();
        $this->initializeModules();
    }

    /**
     * Initialize modules
     */
    private function initializeModules()
    {
        $bootstrap = new Bootstrap($this->container);
        $bootstrap->bind()->use();
    }

    /**
     * Run the application
     */
    public function run()
    {
        $this->setupEnvironment();
        $this->useHelpersFunctions();
        $this->resolveDependencies();
        $this->router->dispatch();
    }

    /**
     * Set up environment specific configurations
     */
    private function setupEnvironment()
    {
        if ($this->environment() === 'dev') {
            $this->development();
        }
    }

    /**
     * Resolve dependencies
     */
    private function resolveDependencies()
    {
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
    }
}
