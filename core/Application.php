<?php

namespace Core;

use Core\Interfaces\ContainerInterface;

class Application
{

    public static ContainerInterface $container;

    public static function setContainer(ContainerInterface $container): void
    {
        static::$container = $container;
    }

    public static function container(): ContainerInterface
    {
        return static::$container;
    }

    public static function bindToContainer(string $name, $service): void
    {
        static::container()->bind($name, $service);
    }

}