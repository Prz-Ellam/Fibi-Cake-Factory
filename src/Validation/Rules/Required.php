<?php

namespace Fibi\Validation\Rules;

use Attribute;

/**
 * Verifica que un valor no sea null, cadena vacia o cadena de solo espacios
 */
#[Attribute]
class Required implements RuleValidation
{
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

    /**
     * Checa que un input no sea null, cadena vacía o cadena de solo espacios
     *
     * @param mixed $value
     * @return boolean
     */
    public function isValid(mixed $value) : bool
    {
        return isset($value) && !empty(trim($value));
    }

    /**
     * Devuelve el mensaje de error
     *
     * @return string
     */
    public function message() : string
    {
        return $this->message;
    }
}

?>