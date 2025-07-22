<?php

namespace Core;

use App\Exception\NotFoundException;
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

    private function addRoute(string $uri, array $controller, string $method)
    {
        $this->routes[] = [
            "pattern" => $uri,
            "method" => $method,
            "controller" => $controller
        ];
    }

    public function get(string $uri, array $controller)
    {
        $this->addRoute($uri, $controller, "GET");
    }

    public function post(string $uri, array $controller)
    {
        $this->addRoute($uri, $controller, "POST");
    }

    public function delete(string $uri, array $controller)
    {
        $this->addRoute($uri, $controller, "DELETE");
    }

    public function patch(string $uri, array $controller)
    {
        $this->addRoute($uri, $controller, "PATCH");
    }

    public function put(string $uri, array $controller)
    {
        $this->addRoute($uri, $controller, "PUT");
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

    /**
     * @throws NotFoundException
     */
    public function handle()
    {
        $foundRoute = $this->findRoute();

        if (!$foundRoute) {
            throw new NotFoundException("Route not found", 404);
        }

        $controller = Application::container()->resolve($foundRoute['controller'][0]);

        return call_user_func_array([$controller, $foundRoute['controller'][1]], $foundRoute['params']);
    }

}