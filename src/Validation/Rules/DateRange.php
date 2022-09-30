<?php

namespace Fibi\Validation\Rules;

use Attribute;
use DateTime;

#[Attribute]
class DateRange implements RuleValidation
{
    private DateTime $from;
    private DateTime $to;
    private string $message;

    public function __construct($from, $to) {
        
    }
    
    public function isValid(mixed $input) : bool
    {
        return false;
    }

    public function message() : string
    {
        return "";
    }
}

?>