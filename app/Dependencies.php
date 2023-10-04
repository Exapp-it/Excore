<?php

namespace Excore\App;

use Excore\Core\Config\Env;
use Excore\Core\Config\Path;
use Excore\Core\Config\Assets;
use Excore\Core\Core\Config;
use Excore\Core\Core\RegisterDependencies;
use Excore\Core\Modules\Database\DB;
use Excore\Core\Modules\Http\Request;
use Excore\Core\Modules\Router\Router;
use Excore\Core\Modules\Session\Session;
use Excore\Core\Modules\View\View;


class Dependencies extends RegisterDependencies
{
    public function bind()
    {
        $this->container->register('DB', function () {
            return DB::init(Config::db());
        });

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

        $this->container->register('Env', function () {
            return  Env::init(Path::root());
        });

        $this->container->register('Config', function () {
            return  Config::init(Path::config());
        });

        return $this;
    }
}
