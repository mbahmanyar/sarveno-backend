<?php

namespace Core;

use App\Exception\NotFoundException;
use Core\Interfaces\MiddlewareInterface;

class Router
{
    private array $routes;


    public function __construct(
        private readonly string $requestUri,
        private readonly string $requestMethod
    )
    {
    }

    /**
     * @param string $uri
     * @param array $controller
     * @param string $method
     * @param Array<MiddlewareInterface> $middlewares
     * @return void
     */
    private function addRoute(string $uri, array $controller, string $method, array $middlewares=[])
    {
        $uri = $this->compileUri($uri);

        $this->routes[] = [
            "pattern" => $uri,
            "method" => $method,
            "controller" => $controller,
            "middleware" => $middlewares
        ];
    }

    public function get(string $uri, array $controller, ?array $middlewares = [])
    {
        $this->addRoute($uri, $controller, "GET", $middlewares);
    }

    public function post(string $uri, array $controller, ?array $middlewares = [])
    {
        $this->addRoute($uri, $controller, "POST", $middlewares);
    }

    public function delete(string $uri, array $controller, ?array $middlewares = [])
    {
        $this->addRoute($uri, $controller, "DELETE", $middlewares);
    }

    public function patch(string $uri, array $controller, ?array $middlewares = [])
    {
        $this->addRoute($uri, $controller, "PATCH", $middlewares);
    }

    public function put(string $uri, array $controller, ?array $middlewares = [])
    {
        $this->addRoute($uri, $controller, "PUT", $middlewares);
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

        if ($foundRoute['middleware']) {
            foreach ($foundRoute['middleware'] as $middleware) {
                $middlewareInstance = Application::container()->resolve($middleware);
                if (!$middlewareInstance instanceof MiddlewareInterface) {
                    throw new \Exception("Middleware must implement MiddlewareInterface");
                }
                $middlewareInstance->handle();
            }
        }

        $controller = Application::container()->resolve($foundRoute['controller'][0]);

        return call_user_func_array([$controller, $foundRoute['controller'][1]], $foundRoute['params']);
    }

    private function compileUri(string $uri)
    {
        $uri = str_replace("/", "\/", $uri); // remove leading slash
        return "/^{$uri}$/";
    }

}