<?php

namespace Excore\Core\Core;


use Whoops\Run;
use Excore\Core\Core\Config;
use Whoops\Handler\PrettyPageHandler;

abstract class CoreApp
{

    protected string $environment = '';

    public function __construct()
    {
        $this->environment = env('ENVIROMENT');
    }

    protected function environment(): string
    {

        return $this->environment;
    }

    protected function development(): void
    {
        $whoops = new Run;
        $whoops->pushHandler(new PrettyPageHandler);
        $whoops->register();
    }

    protected function useHelpersFunctions()
    {
        require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'helpers/Helpers.php';
        require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'helpers/Functions.php';
    }
}
