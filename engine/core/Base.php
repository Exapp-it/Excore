<?php

namespace Excore\Core\Core;

use Excore\Core\Helpers\Path;
use Excore\Core\Core\Container;

abstract class Base
{
    public $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->container->register('Path', function () {
            return Path::init();
        });
        $this->container->register('Config', function () {
            return Config::init(Path::config());
        });
    }
}
