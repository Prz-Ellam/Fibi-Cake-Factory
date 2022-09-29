<?php

namespace Fibi\Validation\Rules;

use Attribute;

#[Attribute]
class HasSpecialChars implements RuleValidation
{
    private const REGEX = "/[¡”\"#$%&;\/=’?!¿:;,.\-_+*{}\[\]]/";
    private string $message;

    public function isValid(mixed $input) : bool
    {
        return preg_match(self::REGEX, $input);
    }

    public function message() : string
    {
        return "";
    }
}

?>