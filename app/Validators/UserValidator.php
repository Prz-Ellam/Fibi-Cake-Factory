<?php

namespace CakeFactory\Validators;

use CakeFactory\Models\User;
use Fibi\Validation\Rules\Email;
use Fibi\Validation\Rules\Required;
use Fibi\Validation\Validator;

class UserValidator extends Validator
{
    private array $instance;
    private array $rules;

    public function __construct(User $user)
    {
        $this->instance = $user->toObject();
        $this->rules = [
            "email" => [ "required", "email" ],
            "username" => [ "required" ],
            "firstName" => [ "required" ],
            "lastName" => [ "required" ],
            "visibility" => [ "required" ],
            "gender" => [ "required" ],
            "birthDate" => [ "required" ],
            "password" => [ "required" ] 
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