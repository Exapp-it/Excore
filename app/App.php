<?php

namespace Excore\App;

use Excore\App\Dependencies;
use Excore\Core\Core\Container;
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
    protected Container $container;

    public  function __construct(protected string $mode)
    {
        $this->container = new Container();
        (new Dependencies($this->container))->bind()->use();
    }

    public function run()
    {

        if ($this->mode() === 'dev') {
            $this->devMode();
        }

        $this->request = $this->container->resolve('Request');
        $this->container->resolve('Path');
        $this->container->resolve('Assets');
        $this->session = $this->container->resolve('Session');
        $this->view = $this->container->resolve('View');
        $this->router = $this->container->resolve('Router');
        $this->router->dispatch();
    }


    private function mode(): string
    {
        return $this->mode;
    }

    private function devMode(): void
    {
        $whoops = new Run;
        $whoops->pushHandler(new PrettyPageHandler);
        $whoops->register();
    }
}
