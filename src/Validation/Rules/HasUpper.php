<?php

namespace Fibi\Validation\Rules;

class HasUpper implements RuleValidation
{
    private string $message;
    
    public function isValid(mixed $input) : bool
    {
        return preg_match("/[a-z]/", $input);
    }

    public function message() : string
    {
        return "";
    }
}

?>