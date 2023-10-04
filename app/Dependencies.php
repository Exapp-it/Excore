<?php

namespace Excore\App;

use Excore\Core\Config\Path;
use Excore\Core\Core\Assets;
use Excore\Core\Core\RegisterDependencies;
use Excore\Core\Modules\Http\Request;
use Excore\Core\Modules\Router\Router;
use Excore\Core\Modules\Session\Session;
use Excore\Core\Modules\View\View;


class Dependencies extends RegisterDependencies
{
    public function bind()
    {
        $this->container->register('Request', function () {
            return Request::init();
        });

        $this->container->register('Session', function () {
            return Session::init();
        });

        $this->container->register('View', function () {
            return  View::init($this->container->resolve('Request'));
        });

        $this->container->register('Router', function () {
            return  Router::init(
                $this->container->resolve('Request'),
                $this->container->resolve('View')
            );
        });

        return $this;
    }

    public function use()
    {

        $this->container->register('Path', function () {
            return Path::init($this->container->resolve('Request'));
        });

        $this->container->register('Assets', function () {
            return  Assets::init($this->container->resolve('Request'));
        });

        return $this;
    }
}
