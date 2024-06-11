<?php

namespace App\Core;

use App\Exceptions\RouteNotFoundException;

class Router
{
    private array $routes = [];
    private array $arguments = [];

    /**
     * Add a route to the routing table.
     *
     * @param string $method
     * @param string $route
     * @param array $callback
     * @param string|null $middleware
     * @return void
     */
    public function add(string $method, string $route, array $callback, ?string $middleware = null): void
    {
        $this->routes[] = [
            'method' => $method,
            'route' => $route,
            'callback' => $callback,
            'middleware' => $middleware,
        ];
    }

    /**
     * Dispatch the route, creating the controller object and running the action method.
     *
     * @param string $uri
     * @param string $method
     * @return void
     * @throws RouteNotFoundException
     */
    public function dispatch(string $uri, string $method)
    {
        $parsedUrl = parse_url($uri);
        $path = $parsedUrl['path'] ?? '';

        foreach ($this->routes as $route) {
            if ($route['route'] === $path && $route['method'] === $method) {
                $this->handleMiddleware($route['middleware']);

                [$controller, $method] = $route['callback'];
                $controllerInstance = new $controller();

                if (!method_exists($controllerInstance, $method)) {
                    throw new RouteNotFoundException("Method $method not found in controller $controller");
                }

                return $controllerInstance->$method();
            }
        }

        $this->handleNotFound();
    }

    /**
     * Handle the middleware for the route.
     *
     * @param string|null $middleware
     * @return void
     */
    private function handleMiddleware(?string $middleware): void
    {
        if ($middleware !== null) {
            $middlewareInstance = new $middleware();
            $middlewareInstance->handle();
        }
    }

    /**
     * Handle the route not found scenario.
     *
     * @return void
     * @throws RouteNotFoundException
     */
    private function handleNotFound(): void
    {
        throw new RouteNotFoundException('404 - Not Found');
    }

    /**
     * Define a group of routes with a common middleware.
     *
     * @param array $routes
     * @param string|null $middleware
     * @return void
     */
    public function group(array $routes, ?string $middleware = null): void
    {
        foreach ($routes as $route) {
            [$method, $route, $callback] = $route;
            $this->add($method, $route, $callback, $middleware);
        }
    }

    /**
     * @param string $path
     * @param array $segmentsMap
     * @return array
     */
    private function createSegmentsMap(string $path, array $segmentsMap = []) : array
    {
        $array_path = explode('/', $path);
        array_shift($array_path);
        foreach($array_path as $key => $segment)
            if (preg_match('/{(.*?)}/', $segment))
                $segmentsMap[$key] = $segment;

        return $segmentsMap;
    }
}
