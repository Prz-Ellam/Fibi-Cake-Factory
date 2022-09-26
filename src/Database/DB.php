<?php

namespace Fibi\Database;

use Fibi\Core\Application;

class DB
{
    public static function executeNonQuery(string $query, array $parameters = []) : int
    {
        return Application::app()->database->executeNonQuery($query, $parameters);
    }

    public static function executeReader(string $query, array $parameters = []) : array
    {
        return Application::app()->database->executeReader($query, $parameters);
    }
}
