<?php

namespace Fibi\Validation\Rules;

class Number
{
    /**
     * Valida si un objeto es un numero
     *
     * @param string $field Nombre del campo a validar
     * @param array $data Objeto a validar
     * @return boolean
     */
    public static function isValid(string $field, array $data) : bool
    {
        return is_numeric($data[$field]);
    }
}

?>