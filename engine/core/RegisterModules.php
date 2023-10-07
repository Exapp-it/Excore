<?php

namespace Excore\Core\Core;

use Excore\Core\Core\Container;

class RegisterModules
{
    public $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }
}
