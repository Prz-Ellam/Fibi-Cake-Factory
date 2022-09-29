<?php

namespace Fibi\Validation\Rules;

use Attribute;

#[Attribute]
class MaxLength implements RuleValidation
{
    private int $maxlength;
    private string $message;

    public function __construct(int $maxlength, ?string $message = null)
    {
        $this->maxlength = $maxlength;    
    }

    public function isValid(mixed $value) : bool
    {
        return strlen($value) <= $this->maxlength;
    }

    public function message() : string
    {
        return "El campo es demasiado largo";
    }
}

?>