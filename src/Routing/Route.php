<?php

namespace Fibi\Routing;

use Closure;

class Route
{
    private const URI_VARIABLES = "/\{([A-Za-z]+)\}/";

    private string $uri;
    private Closure|array $action;
    private string $regex;

    /**
     * Array of the route parameters in the Uri
     *
     * @var string[]
     */
    private array $parameters;

    public function __construct(string $uri, Closure|array $action) {

        $this->uri = $uri;
        $this->action = $action;

        $groups = [];
        preg_match_all(self::URI_VARIABLES, $this->uri, $groups);
        $this->parameters = $groups[1];

        $this->regex = $this->uri;
        foreach ($this->parameters as $parameter)
        {
            $this->regex = preg_replace("#\{$parameter\}#", "(?<$parameter>[A-Za-z0-9-]+)", $this->regex);
        }
    }

    public function getUri()
    {
        return $this->uri;
    }

    public function getAction() : Closure|array
    {
        return $this->action;
    }

    public function match(string $uri) : bool
    {
        return preg_match("#^$this->regex$#", $uri);
    }

    public function getParameters(string $uri) : array
    {
        $parameters = [];
        preg_match("#$this->regex#", $uri, $parameters);

        foreach ($parameters as $key => $value)
        {
            if (!in_array($key, $this->parameters))
            {
                unset($parameters[$key]);
            }
        }

        return $parameters;
    }


    public static function get(string $uri, Closure $action)
    {

    }

    public static function post(string $uri, Closure $action)
    {

    }

    public static function put(string $uri, Closure $action)
    {

    }

    public static function patch(string $uri, Closure $action)
    {

    }

    public static function delete(string $uri, Closure $action)
    {
        
    }


    
}

?>