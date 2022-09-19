<?php

namespace Fibi\Validation\Rules;

class Required
{
    public static function isValid(string $field, array $data) : bool
    {
        return (!isset($data[$field]) ?? null) || (trim($data[$field]) === "");
    }
}

?>