<?php

namespace Excore\Core\Core;

use Excore\Core\Core\Container;

abstract class Base
{
    public $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }
}
