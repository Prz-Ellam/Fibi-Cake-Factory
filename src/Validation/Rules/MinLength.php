<?php

namespace Fibi\Validation\Rules;

class MinLength implements RuleValidation
{
    private int $minlength;
    private string $message;

    public static function isVaslid(string $field, array $data) : bool
    {
        return strlen($data[$field]) < 25;
    }

    public function isValid(mixed $input) : bool
    {
        return false;
    }

    public function message() : string
    {
        return "";
    }
}

?>