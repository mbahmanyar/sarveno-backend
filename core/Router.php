<?php

namespace Core;

use Closure;
use Exception;

class Router
{
    private array $routes;


    public function __construct(
        private readonly string $requestUri,
        private readonly string $requestMethod
    )
    {
    }

    public function get(string $uri, array $controller)
    {
        $this->routes[] = [
            "pattern" => $uri,
            "method" => "GET",
            "controller" => $controller
        ];
    }

    public function post(string $uri, ?Closure $param)
    {
        $this->routes[] = [
            "pattern" => $uri,
            "method" => "POST",
        ];
    }

    public function findRoute()
    {

        foreach ($this->routes as $route) {
            if (preg_match($route['pattern'], $this->requestUri, $params) && $route['method'] === $this->requestMethod) {
                array_shift($params);
                return [...$route, "params" => $params];
            }
        }
    }

    public function handle()
    {
        $foundRoute = $this->findRoute();

        if (!$foundRoute) {
            // todo handle exception
            throw new Exception("Route not found", 404);
        }

        return call_user_func_array([new $foundRoute['controller'][0], $foundRoute['controller'][1]], $foundRoute['params']);
    }

}