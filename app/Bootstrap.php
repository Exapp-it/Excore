<?php

namespace Excore\App;

use Excore\Core\Core\Base;
use Excore\Core\Core\Config;
use Excore\Core\Helpers\Env;
use Excore\Core\Helpers\Hash;
use Excore\Core\Helpers\Path;
use Excore\Core\services\Auth;
use Excore\Core\Helpers\Assets;
use Excore\Core\Modules\View\View;
use Excore\Core\Modules\Database\DB;
use Excore\Core\Modules\Http\Request;
use Excore\Core\Modules\Http\Response;
use Excore\Core\Modules\Router\Router;
use Excore\Core\Modules\Session\Session;

/**
 * Class Bootstrap
 * @package Excore\App
 */
class Bootstrap extends Base
{
    /**
     * Register dependencies
     */
    public function bind()
    {
        $this->registerDB();
        $this->registerRequest();
        $this->registerResponse();
        $this->registerSession();
        $this->registerView();
        $this->registerRouter();
        $this->registerAuth();

        return $this;
    }

    /**
     * Use configurations
     */
    public function use()
    {
        $this->registerPath();
        $this->registerAssets();
        $this->registerEnv();
        $this->registerConfig();
        $this->registerHash();

        return $this;
    }

    /**
     * Register DB instance
     */
    private function registerDB()
    {
        $this->container->register('DB', function () {
            return DB::getInstance(Config::db());
        });
    }

    /**
     * Register Request instance
     */
    private function registerRequest()
    {
        $this->container->register('Request', function () {
            return Request::init();
        });
    }

    /**
     * Register Response instance
     */
    private function registerResponse()
    {
        $this->container->register('Response', function () {
            return Response::init();
        });
    }

    /**
     * Register Session instance
     */
    private function registerSession()
    {
        $this->container->register('Session', function () {
            return Session::init();
        });
    }
    

    /**
     * Register View instance
     */
    private function registerView()
    {
        $this->container->register('View', function () {
            return View::init(request());
        });
    }

    /**
     * Register Router instance
     */
    private function registerRouter()
    {
        $this->container->register('Router', function () {
            return Router::init(
                request(),
                response(),
                session(),
                view(),
            );
        });
    }

    /**
     * Register Auth instance
     */
    private function registerAuth()
    {
        $this->container->register('Auth', function () {
            return Auth::init(
                request(),
                session()
            );
        });
    }

    /**
     * Register Path instance
     */
    private function registerPath()
    {
        $this->container->register('Path', function () {
            return Path::init();
        });
    }

    /**
     * Register Assets instance
     */
    private function registerAssets()
    {
        $this->container->register('Assets', function () {
            return Assets::init(request());
        });
    }

    /**
     * Register Env instance
     */
    private function registerEnv()
    {
        $this->container->register('Env', function () {
            return Env::init(Path::root());
        });
    }

    /**
     * Register Config instance
     */
    private function registerConfig()
    {
        $this->container->register('Config', function () {
            return Config::init(Path::config());
        });
    }

    /**
     * Register Hash instance
     */
    private function registerHash()
    {
        $this->container->register('Hash', function () {
            return Hash::init(session());
        });
    }
}
