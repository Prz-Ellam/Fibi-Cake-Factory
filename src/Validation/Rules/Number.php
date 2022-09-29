<?php

namespace Fibi\Validation\Rules;

use Attribute;

#[Attribute]
class Number implements RuleValidation
{
    public function isValid(mixed $input) : bool
    {
        return false;
    }

    public function message() : string
    {
        return "";
    }

    public function valid(string $input) : bool
    {
        return is_numeric($input);
    }
}

?>