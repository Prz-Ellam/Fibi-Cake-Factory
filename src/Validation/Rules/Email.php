<?php

namespace Fibi\Validation\Rules;

use Attribute;

#[Attribute]
class Email implements RuleValidation
{
    private const EMAIL_REGEX = "/(?:[a-z0-9!#$%&'*+\/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+\/=?^_`{|}~-]+)*|\"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*\")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])/";
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

    public function isValid(mixed $value) : bool
    {
        return preg_match(self::EMAIL_REGEX, $value);
    }

    public function message() : string
    {
        return $this->message;
    }
}
