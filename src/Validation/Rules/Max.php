<?php

namespace Fibi\Validation\Rules;

use Attribute;

#[Attribute]
class Max implements RuleValidation
{
    private int $max;
    private string $message;

    public function __construct(int $max, ?string $message)
    {
        $this->max = $max;
        if (is_null($message))
        {
            $this->message = "El valor que mando es mayor a $this->max caracteres";
        }
        else
        {
            $this->message = $message;
        }    
    }

    public function isValid(mixed $value) : bool
    {
        return $value < $this->max;
    }

    public function message() : string
    {
        return $this->message;
    }
}

?>