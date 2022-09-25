<?php

namespace Fibi\Validation\Rules;

class MaxLength 
{
    public static function isValid(string $field, array $data) : bool
    {
        return strlen($data[$field]) < 25;
    }
}

?>