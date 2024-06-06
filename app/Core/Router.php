<?php

namespace App\Core;

use App\Exceptions\RouteNotFoundException;
use App\Middleware\AdminMiddleware;

class Router
{
    private array $routes = [];
    private array $middleware = [];

    public function add($route, $callback, $middleware = null): void
    {
        $this->routes[$route] = $callback;
        $this->middleware[$route] = $middleware;
    }

    /**
     * @throws RouteNotFoundException
     */
    public function dispatch($uri): void
    {
        $uri = parse_url($uri, PHP_URL_PATH);

        if (array_key_exists($uri, $this->routes)) {
            $this->handleMiddleware($uri);

            $callback = $this->routes[$uri];
            [$controller, $method] = $callback;

            // Instantiate controller and call method
            $controllerInstance = new $controller();
            $controllerInstance->$method();
        } else {
            $this->handleNotFound();
        }
    }

    private function handleMiddleware(string $uri): void
    {
        if (isset($this->middleware[$uri])) {
            $middleware = $this->middleware[$uri];
            $middlewareInstance = new $middleware();
            $middlewareInstance->handle();
        }
    }

    /**
     * @throws RouteNotFoundException
     */
    private function handleNotFound(): void
    {
        throw new RouteNotFoundException('404 - Not Found');
    }
}
