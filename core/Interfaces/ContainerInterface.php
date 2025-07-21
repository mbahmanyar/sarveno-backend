<?php

namespace Core\Interfaces;

interface ContainerInterface
{
    public function bind(string $name, $service): void;

    public function resolve(string $name);
}