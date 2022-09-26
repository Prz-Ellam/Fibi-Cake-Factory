<?php

namespace Fibi\Validation;

use ReflectionClass;
use ReflectionProperty;

class Validator
{
    private object $instance;

    public function __construct(object $instance)
    {
        $this->instance = $instance;    
    }

    public function validate() : array
    {
        // Obtiene las propiedades de una clase
        $properties = $this->instance::getProperties();
        $values = $this->instance->toObject();
        $results = [];

        foreach ($properties as $property)
        {
            $reflectionProperty = new ReflectionProperty($this->instance::class, $property);
            $attributes = $reflectionProperty->getAttributes();

            foreach ($attributes as $attribute)
            {
                $attributeName = $attribute->getName();
                $attributeInstance = $attribute->newInstance();
                $status = $attributeInstance->isValid($values[$property]);

                if ($status === false)
                {
                    $results[$property][$attributeName] = $attributeInstance->message();
                }
                
            }
        }

        return $results;
    }
}

?>