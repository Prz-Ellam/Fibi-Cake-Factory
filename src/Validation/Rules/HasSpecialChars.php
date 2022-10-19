<?php

namespace Fibi\Validation\Rules;

use Attribute;

#[Attribute]
class HasSpecialChars implements RuleValidation
{
    private const REGEX = "/[¡”\"#$%&;\/=’?!¿:;,.\-_+*{}\[\]]/";
    private string $message;

    public function __construct(?string $message = null) {
        if (is_null($message))
        {
            $this->message = "Por favor ingrese un valor";
        }
        else
        {
            $this->message = $message;
        }
    }

    public function isValid(mixed $input) : bool
    {
        return preg_match(self::REGEX, $input);
    }

    public function message() : string
    {
        return $this->message;
    }
}

?>