<?php

namespace Fibi\Routing;

use Closure;
use Fibi\Http\HttpMethod;
use Fibi\Http\Request;

/**
 * Gestiona las rutas y redirige a los recursos solicitados
 */
class Router
{
    /**
     * Arreglo de rutas
     *
     * @var array<string, Routes[]>
     */
    private $routes = [];

    public function __construct()
    {
        foreach(HttpMethod::cases() as $method)
        {
            $this->routes[$method->value] = [];
        }
    }

    public function __destruct()
    {
        $routes = [];
    }

    public function addRoute(HttpMethod $method, string $uri, Closure|array $action)
    {
        $this->routes[$method->value][] = new Route($uri, $action);
    }

    public function get(string $uri, Closure|array $action)
    {
        $this->addRoute(HttpMethod::GET, $uri, $action);
    }

    public function post(string $uri, Closure|array $action)
    {
        $this->addRoute(HttpMethod::POST, $uri, $action);
    }

    public function put(string $uri, Closure|array $action)
    {
        $this->addRoute(HttpMethod::PUT, $uri, $action);
    }

    public function patch(string $uri, Closure|array $action)
    {
        $this->addRoute(HttpMethod::PATCH, $uri, $action);
    }

    public function delete(string $uri, Closure|array $action)
    {
        $this->addRoute(HttpMethod::DELETE, $uri, $action);
    }

    public function resolveRoute(Request $request) : Route|null
    {
        $uri = $request->getUri();
        $method = $request->getMethod()->value;

        foreach($this->routes[$method] as $route)
        {
            if ($route->match($uri))
            {
                return $route;
            }
        }

        return null;
    }

    public function resolve(Request $request) : Closure|array|null 
    {
        $route = $this->resolveRoute($request);
        $request->setRoute($route);

        $uri = $request->getUri();
        $method = $request->getMethod()->value;

        foreach($this->routes[$method] as $route)
        {
            if ($route->match($uri))
            {
                return $route->getAction();
            }
        }

        return null;
    }
}

?>