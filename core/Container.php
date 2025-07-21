<?php

namespace Core;

use Core\Interfaces\ContainerInterface;
use Exception;

class Container implements ContainerInterface
{

    protected $services = [];

    // todo add singleton support
    public function bind(string $name, $service): void
    {
        $this->services[$name] = $service;
    }

    public function resolve(string $name)
    {
        if (!isset($this->services[$name])) {
            throw new Exception("Service not found: " . $name);
        }
        return $this->services[$name];
    }

}