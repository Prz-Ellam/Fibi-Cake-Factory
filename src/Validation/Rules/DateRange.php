<?php

namespace Fibi\Validation\Rules;

class DateRange implements RuleValidation
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