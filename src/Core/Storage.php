<?php

namespace Fibi\Core;

class Storage
{
    public static function set(string $name, mixed $value)
    {
        Application::app()->setItem($name, $value);
    }

    public static function get(string $name) : ?string
    {
        return Application::app()->getItem($name);
    }
}
