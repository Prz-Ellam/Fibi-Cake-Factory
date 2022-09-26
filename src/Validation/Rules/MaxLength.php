<?php

namespace Fibi\Validation\Rules;

class MaxLength implements RuleValidation
{
    private int $maxlength;
    private string $message;

    public function __construct(int $maxlength, ?string $message = null) {
        
    }

    public function isValid(mixed $input) : bool
    {
        return false;
    }

    public function message() : string
    {
        return "";
    }

    public function valid(mixed $input) : bool
    {
        return strlen($input) < $this->length;
    }
}

?>