<?php

namespace Fibi\Validation\Rules;

use Attribute;

#[Attribute]
class Regex implements RuleValidation
{
    private string $regex;
    private string $message;

    public function __construct(string $regex, ?string $message = null) {
        $this->regex = $regex;
        if (is_null($message))
        {
            $this->message = "Por favor ingrese un valor";
        }
        else
        {
            $this->message = $message;
        }
    }

    public function isValid(mixed $value) : bool
    {
        return preg_match($this->regex, $value);
    }

    public function message() : string
    {
        return $this->message;
    }
}
