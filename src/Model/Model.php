<?php

namespace Fibi\Model;

interface Model
{
    public function toObject() : array;
    public static function getProperties() : array;
}

?>