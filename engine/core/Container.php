<?php

namespace Excore\Core\Core;
use Excore\Core\Core\Exceptions\ContainerException;


class Container
{
    private $dependencies = [];
    private static $instance;

    private function __construct()
    {
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function register($name, $dependency)
    {
        $this->dependencies[$name] = $dependency;
    }

    public function resolve($name)
    {
        if (isset($this->dependencies[$name])) {
            if (is_callable($this->dependencies[$name])) {
                $this->dependencies[$name] = $this->dependencies[$name]();
            }
            return $this->dependencies[$name];
        }

        throw new ContainerException("Dependency not found: $name");
    }
}

