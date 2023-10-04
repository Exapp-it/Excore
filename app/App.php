<?php

namespace Excore\App;

use Excore\Core\Config\Path;
use Excore\Core\Core\Assets;
use Excore\Core\Modules\Http\Request;
use Excore\Core\Modules\Router\Router;
use Excore\Core\Modules\View\View;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;

class App
{

    public  function __construct(
        protected string $mode
    ) {
    }

    public function run()
    {

        if ($this->mode() === 'dev') {
            $this->devMode();
        }

        $request = Request::init();
        Path::init($request);
        Assets::init($request);
        $view = new View($request);
        $router = new Router($request, $view);
        $router->dispatch();
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
