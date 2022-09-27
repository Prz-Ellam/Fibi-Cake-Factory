<?php

namespace Fibi\Helpers;

class Parser
{
    public static function SP(string $storedProcedure)
    {
        $parameters = [];
        preg_match_all("/:([A-Za-z0-9_]+)[,()]/", $storedProcedure, $parameters);
        return $parameters[1];
    }
}
