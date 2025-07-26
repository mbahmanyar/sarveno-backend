<?php

namespace Core;

use App\Exception\NotFoundException;
use Core\Interfaces\MiddlewareInterface;

class Router
{
    private array $routes;
    private array $matchedRoute = [];



    public function __construct(
        private readonly string $requestUri,
        private readonly string $requestMethod
    )
    {
    }

    public function getMatchedRouteParams() : array
    {
        return $this->matchedRoute['params'] ?? [];
    }

    /**
     * @param string $uri
     * @param array $controller
     * @param string $method
     * @param Array<MiddlewareInterface> $middlewares
     * @return void
     */
    private function addRoute(string $uri, array $controller, string $method, array $middlewares = [])
    {
        $uri = $this->compileUri($uri);

        $this->routes[] = [
            "pattern" => $uri,
            "method" => $method,
            "controller" => $controller[0],
            "action" => $controller[1],
            "middlewares" => $middlewares
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

    public function findMatchedRoute(): void
    {

        foreach ($this->routes as $route) {
            if (preg_match($route['pattern'], $this->requestUri, $params) && $route['method'] === $this->requestMethod) {
                array_shift($params);
                $params = array_filter($params, fn($key) => !is_numeric($key), ARRAY_FILTER_USE_KEY);
                $this->matchedRoute = [...$route, "params" => $params];
                break;
            }
        }
    }

    /**
     * @throws NotFoundException
     */
    public function handle()
    {
        /** @var ['pattern', 'method', 'controller', 'middleware', 'params'] $foundRoute */
        $this->findMatchedRoute();

        if (!$this->matchedRoute) {
            throw new NotFoundException("Route not found", 404);
        }

        if ($this->matchedRoute['middlewares']) {
            foreach ($this->matchedRoute['middlewares'] as $middleware) {
                $middlewareInstance = Application::container()->resolve($middleware);
                if (!$middlewareInstance instanceof MiddlewareInterface) {
                    throw new \Exception("Middleware must implement MiddlewareInterface");
                }
                $middlewareInstance->handle();
            }
        }

        $controller = Application::container()->resolve($this->matchedRoute['controller']);


        return call_user_func_array([$controller, $this->matchedRoute['action']], $this->matchedRoute['params']);
    }

    private function compileUri(string $uri)
    {
        $uri = preg_replace_callback("/{([^}]+)}/", function ($m) {
            return '(?P<' . $m[1] . '>\d+)';
        }, $uri); // remove leading slash
        $uri = str_replace("/", "\/", $uri); // remove leading slash
        return "/^{$uri}$/";
    }

}