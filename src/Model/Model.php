<?php

namespace Fibi\Model;

interface Model
{
    /**
     * Expone los miembros del modelo en formato de arreglo
     *
     * @return array
     */
    /*
    public function toObject()
    {
        $members = get_object_vars($this);
        return json_decode(json_encode($members), true);
    }
    */

    public function toObject() : array;

    public static function getProperties() : array;
}

?>