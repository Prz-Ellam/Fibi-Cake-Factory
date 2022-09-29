<?php

namespace Fibi\Validation\Rules;

use Attribute;

#[Attribute]
class Uuid implements RuleValidation
{
    private const REGEX = "/^[0-9a-fA-F]{8}\b-[0-9a-fA-F]{4}\b-[0-9a-fA-F]{4}\b-[0-9a-fA-F]{4}\b-[0-9a-fA-F]{12}$/";

    public function isValid(mixed $value) : bool
    {
        return preg_match(self::REGEX, $value);
    }

    public function message() : string
    {
        return "El id proporcionado no es un uuid";
    }

}
