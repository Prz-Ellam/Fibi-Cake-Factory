<?php

namespace Fibi\Database;

use Fibi\Core\Application;

class DB
{
    public static function executeNonQuery(string $query, array $parameters = []): int|string
    {
        return Application::app()->database->executeNonQuery($query, $parameters);
    }

    public static function executeReader(string $query, array $parameters = []): array
    {
        return Application::app()->database->executeReader($query, $parameters);
    }

    public static function beginTransaction()
    {
        return Application::app()->database->beginTransaction();
    }

    public static function endTransaction()
    {
        return Application::app()->database->endTransaction();
    }
}
