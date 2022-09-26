<?php

namespace Fibi\Validation\Rules;

class HasNumber implements RuleValidation
{
    private const REGEX = "/[0-9]/";
    private string $message;

    public function isValid(mixed $input) : bool
    {
        return preg_match("/[0-9]/", $input);
    }

    public function message() : string
    {
        return "";
    }
}

?>