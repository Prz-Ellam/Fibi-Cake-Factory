<?php

namespace Fibi\Validation;

use ReflectionClass;
use ReflectionProperty;

/**
 * Recibe un objeto y lo valida de acuerdo a sus atributos
 */
class Validator
{
    private object $instance;
    private array $feedback;
    private ?bool $status;

    public function __construct(object $instance)
    {
        $this->instance = $instance;
        $this->status = null;
    }

    /**
     * Valida el objeto y sus reglas
     *
     * @return array Lista de las reglas no cumplidas
     */
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
                $attributeInstance = $attribute->newInstance();
                $class = new ReflectionClass($attributeInstance);
                $attributeName = $class->getShortName();
                $status = $attributeInstance->isValid($values[$property]);

                if ($status === false)
                {
                    $results[$property][$attributeName] = $attributeInstance->message();
                }
                
            }
        }

        if (count($results) === 0)
        {
            $this->status = true;
        }
        else
        {
            $this->status = false;
        }

        return $results;
    }

    /**
     * Devuelve null si aun no se ha hecho la validacion
     * En caso de haberse hecho regresa true si todo esta correcto y false si hubo errores
     *
     * @return boolean|null
     */
    public function getStatus() : ?bool
    {
        return $this->status;
    }
}

?>