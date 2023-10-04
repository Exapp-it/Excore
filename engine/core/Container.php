<?php

namespace Excore\Core\Core;

use Excore\Core\Core\Exception\ContainerException;



class Container
{

    private $dependencies = [];

    public function register($name, $dependency)
    {
        $this->dependencies[$name] = $dependency;
    }

    public function resolve($name)
    {
        if (isset($this->dependencies[$name])) {
            return $this->dependencies[$name]();
        }

        throw new ContainerException("Dependency not found: $name");
    }
}
