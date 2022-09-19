<?php

namespace Fibi\Http\Request;

class PhpCookie implements Cookie
{
    public function get(string $key) : string
    {
        return $_COOKIE[$key];
    }

    public function set(string $key, string $value, int $timeout = 0) : void
    {
        setcookie($key, $value, $timeout, '/');
    }
}

?>