<?php

namespace CakeFactory\Validators;

use CakeFactory\Models\Category;
use Fibi\Validation\Rules\Email;
use Fibi\Validation\Rules\Required;
use Fibi\Validation\Validator;

class CategoryValidator extends Validator
{
    private array $instance;
    private array $rules;

    public function __construct(Category $category) {
        $this->instance = $category->toObject();
        $this->rules = [
            "name" => [ "required" ]
        ];
    }

    public function validate()
    {
        foreach ($this->rules as $name => $rules)
        {
            foreach ($rules as $key => $rule)
            {
                $result = false;
                switch ($rule)
                {
                    case "required":
                        $result = Required::isValid($name, $this->instance);
                        break;
                    case "email":
                        $result = Email::isValid($name, $this->instance);
                        break;
                }

                if ($result === true)
                {
                    return false;
                }
            }
        }

        return true;
    }
}

?>