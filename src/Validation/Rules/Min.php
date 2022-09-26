<?php

namespace Fibi\Validation\Rules;

use Attribute;

#[Attribute]
class Min implements RuleValidation
{
    private int $min;
    private string $message;

    public function __construct(int $min, ?string $message = null) {
        $this->min = $min;
        if (is_null($message))
        {
            $this->message = "El valor que mando es menor a $this->min caracteres";
        }
        else
        {
            $this->message = $message;
        }  
    }

    public function isValid(mixed $value) : bool
    {
        return $value > $this->min;
    }

    public function message() : string
    {
        return $this->message;
    }
}

?>