<?php

namespace Fibi\Validation\Rules;

use Attribute;
use Fibi\Core\Storage;

#[Attribute]
class EqualTo implements RuleValidation
{
    private string $equalToName;
    private string $message;

    public function __construct(string $name, ?string $message = null)
    {
        $this->equalToName = $name;
        if (is_null($message))
        {
            $this->message = "Los valores no coinciden";
        }
        else
        {
            $this->message = $message;
        }
    }
    
    public function isValid(mixed $value) : bool
    {
        return ($value === Storage::get($this->equalToName));
    }

    public function message() : string
    {
        return $this->message;
    }
}

?>