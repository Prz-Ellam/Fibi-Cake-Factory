<?php

namespace Fibi\Validation\Rules;

class Phone implements RuleValidation
{
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