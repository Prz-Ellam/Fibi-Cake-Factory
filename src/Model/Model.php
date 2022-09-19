<?php

namespace Fibi\Model;

abstract class Model
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
}

?>