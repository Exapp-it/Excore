<?php

namespace Excore\App;

use Excore\App\Dependencies;
use Excore\Core\Core\Container;
use Excore\Core\Modules\Database\DB;
use Excore\Core\Modules\Http\Request;
use Excore\Core\Modules\Router\Router;
use Excore\Core\Modules\Session\Session;
use Excore\Core\Modules\View\View;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;

class App
{

    public readonly Request $request;
    public readonly View $view;
    public readonly Router $router;
    public readonly Session $session;
    public readonly Container $container;
    public readonly DB $db;

    public  function __construct(protected string $environment)
    {
        $this->container = new Container();
        (new Dependencies($this->container))->bind()->use();
    }

    public function run()
    {

        if ($this->environment() === 'develop') {
            $this->development();
        }

        $this->useHelpers();
        $this->container->resolve('Path');
        $this->container->resolve('Env');
        $this->container->resolve('Config');
        $this->container->resolve('Assets');
        $this->db = $this->container->resolve('DB');
        $this->request = $this->container->resolve('Request');
        $this->session = $this->container->resolve('Session');
        $this->view = $this->container->resolve('View');
        $this->router = $this->container->resolve('Router');
        $this->router->dispatch();
    }


    private function environment(): string
    {
        return $this->environment;
    }

    private function development(): void
    {
        $whoops = new Run;
        $whoops->pushHandler(new PrettyPageHandler);
        $whoops->register();
    }

    private function useHelpers()
    {
        return require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'engine/helpers/helpers.php';
    }
}
