<?php

namespace Fibi\Validation\Rules;

use Attribute;

#[Attribute]
class MinLength implements RuleValidation
{
    private int $minlength;
    private string $message;

    public function __construct(int $minlength, ?string $message = null)
    {
        $this->minlength = $minlength;
    }

    public function isValid(mixed $value) : bool
    {
        return strlen($value) >= $this->minlength;
    }

    public function message() : string
    {
        return "No";
    }
}

?>