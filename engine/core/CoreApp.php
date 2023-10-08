<?php

namespace Excore\Core\Core;


use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;

abstract class CoreApp
{

    protected string $environment = '';

    public function __construct($environment)
    {
        $this->environment = $environment;
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
        return require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'helpers/Functions.php';
    }
}
