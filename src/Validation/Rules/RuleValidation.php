<?php

namespace Fibi\Validation\Rules;

interface RuleValidation
{
    public function isValid(mixed $input) : bool;
    public function message() : string;
}

?>