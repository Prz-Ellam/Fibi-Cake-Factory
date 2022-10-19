<?php

namespace Fibi\Validation\Rules;

use Attribute;
use DateTime;
use Exception;

#[Attribute]
class DateRange implements RuleValidation
{
    private DateTime $from;
    private DateTime $to;
    private string $message;

    public function __construct($from, $to, $message = null) {
        $this->from = new DateTime($from);
        $this->to = new DateTime($to);
        $this->message = $message ?? "Por favor ingrese una fecha valida";
    }
    
    public function isValid(mixed $input) : bool
    {
        try {
            return new DateTime($input) > $this->from && new DateTime($input) < $this->to;
        }
        catch (Exception $ex) {
            return false;
        }
    }

    public function message() : string
    {
        return $this->message;
    }
}

?>