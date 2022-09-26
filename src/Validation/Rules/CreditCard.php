<?php

namespace Fibi\Validation\Rules;

class CreditCard implements RuleValidation
{
    private string $message;

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