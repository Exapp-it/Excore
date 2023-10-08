<?php

namespace Excore\App;

use Excore\Core\Core\ModulesInjection;
use Excore\Core\Helpers\Env;
use Excore\Core\Helpers\Hash;
use Excore\Core\Helpers\Path;
use Excore\Core\Helpers\Assets;
use Excore\Core\Core\Config;
use Excore\Core\Modules\Database\DB;
use Excore\Core\Modules\Http\Request;
use Excore\Core\Modules\Http\Response;
use Excore\Core\Modules\Router\Router;
use Excore\Core\Modules\Session\Session;
use Excore\Core\Modules\View\View;


class Modules extends ModulesInjection
{
    public function bind()
    {
        $this->container->register('DB', function () {
            return DB::getInstance(Config::db());
        });

        $this->container->register('Request', function () {
            return Request::init();
        });

        $this->container->register('Response', function () {
            return Response::init();
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
                $this->container->resolve('Response'),
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

        $this->container->register('Hash', function () {
            return  Hash::init($this->container->resolve('Session'));
        });

        return $this;
    }
}
