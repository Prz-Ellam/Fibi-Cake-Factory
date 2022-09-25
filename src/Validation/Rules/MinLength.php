<?php

namespace Fibi\Validation\Rules;

class MinLength
{
    public static function isValid(string $field, array $data) : bool
    {
        return strlen($data[$field]) < 25;
    }
}

?>