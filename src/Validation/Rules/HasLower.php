<?php

namespace Fibi\Validation\Rules;

use Attribute;

#[Attribute]
class HasLower implements RuleValidation
{
    private const REGEX = "/[a-z]/";
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
        return preg_match("/[a-z]/", $input);
    }

    public function message() : string
    {
        return $this->message;
    }
}
