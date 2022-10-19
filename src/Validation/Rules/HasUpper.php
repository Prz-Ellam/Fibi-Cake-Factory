<?php

namespace Fibi\Validation\Rules;

use Attribute;

#[Attribute]
class HasUpper implements RuleValidation
{
    private string $message;

    public function __construct(?string $message = null) {
        if (is_null($message))
        {
            $this->message = $message ?? "Por favor ingrese un valor";
        }
        else
        {
            $this->message = $message;
        }
    }
    
    public function isValid(mixed $input) : bool
    {
        return preg_match("/[A-Z]/", $input);
    }

    public function message() : string
    {
        return $this->message;
    }
}

?>