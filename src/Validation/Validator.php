<?php

namespace Fibi\Validation;

use Fibi\Validation\Rules\MaxLength;
use Fibi\Validation\Rules\Required;
use ReflectionClass;
use ReflectionProperty;

/**
 * Recibe un objeto y lo valida de acuerdo a sus atributos
 */
class Validator
{
    private object|array $instance;
    private array $feedback;
    private ?bool $status;

    public function __construct(object|array $instance)
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
        if (is_object($this->instance))
        {
            return $this->validateObject();
        }
        elseif (is_array($this->instance))
        {
            return $this->validateArray();
        }
        else
        {
            return [];
        }
    }

    private function validateObject(): array
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

    private function validateArray(): array
    {
        $results = [];

        foreach ($this->instance["rules"] as $property => $rules)
        {
            $status = false;
            if (is_array($rules))
            {
                foreach ($rules as $rule)
                {
                    $status = $rule->isValid($this->instance["values"][$property]);
                    $class = new ReflectionClass($rule);
                    $attributeName = $class->getShortName();
                    if (!$status)
                    {
                        $results[$property][$attributeName] = $rule->message();
                    }
                }
            }
            else
            {
                $status = $rules->isValid($this->instance["values"][$property]);
                $class = new ReflectionClass($rules);
                $attributeName = $class->getShortName();
                if (!$status)
                {
                    $results[$property][$attributeName] = $rules->message();
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
