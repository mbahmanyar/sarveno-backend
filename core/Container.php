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

    /**
     * @throws \ReflectionException
     */
    public function resolve(string $name)
    {
        if (isset($this->services[$name])) {
            return $this->services[$name];
        }

        // If the service is not bound, auto bind it
        if (class_exists($name)) {
            $reflection = new \ReflectionClass($name);
            $constructor = $reflection->getConstructor();
            if ($constructor) {
                $params = [];
                foreach ($constructor->getParameters() as $param) {
                    if ($param->getType() && !$param->getType()->isBuiltin()) {
                        $params[] = $this->resolve($param->getType()->getName());
                    }
                }
                return $reflection->newInstanceArgs($params);
            }
            return new $name();
        }


        throw new Exception("Service not found: " . $name);
    }

}