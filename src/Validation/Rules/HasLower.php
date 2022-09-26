<?php

namespace Fibi\Validation\Rules;

class HasLower implements RuleValidation
{
    private const REGEX = "/[a-z]/";
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