<?php

namespace Fibi\Http\Request;

interface Cookie
{
    public function get(string $key) : ?string;
    public function set(string $key, string $value, int $timeout = 0) : void;
}

?>