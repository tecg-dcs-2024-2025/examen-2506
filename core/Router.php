<?php

namespace Tecgdcs;

class Router
{
    private array $routes;

    private string $uri;

    private string $verb;

    public function __construct()
    {
        $this->routes = require __DIR__.'/../routes.php';
        $this->uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $this->verb = $_SERVER['REQUEST_METHOD'];
    }

    public function route(): void
    {
        $route = $this->get_matching_route();
        [$controller_name, $method] = $route['action'];

        if (!empty($route['middlewares'])) {
            foreach ($route['middlewares'] as $middleware) {
                new $middleware()->handle();
            }
        }
        
        $controller = new $controller_name();
        $controller->$method();
    }

    private function get_matching_route(): ?array
    {
        $routes_f = array_filter(
            $this->routes,
            fn($route) => strtoupper($this->verb) === strtoupper($route['verb'])
                && strtoupper($this->uri) === strtoupper($route['uri'])
        );
        if (empty($routes_f)) {
            Response::abort();
        }

        return array_values($routes_f)[0];
    }
}
