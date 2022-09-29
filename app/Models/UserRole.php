<?php

namespace CakeFactory\Models;

use Fibi\Model\Model;

class UserRole implements Model
{
    private ?string $userRoleId;
    private ?string $name;

    public function getUserRoleId() : ?string
    {
        return $this->userRoleId;
    }

    public function setUserRoleId(?string $userRoleId) : self
    {
        $this->userRoleId = $userRoleId;
        return $this;
    }

    public function getName() : ?string
    {
        return $this->name;
    }

    public function setName(?string $name) : self
    {
        $this->name = $name;
        return $this;
    }

    public function toObject(array $bind = null) : array
    {
        $members = get_object_vars($this);
        $members = json_decode(json_encode($members), true);

        if (is_null($bind) || count($bind) === 0)
        {
            return $members;
        }

        $members = array_filter($members, 
        function($key) use ($bind) { 
            return in_array($key, $bind); 
        }, ARRAY_FILTER_USE_KEY);

        return $members;
    }

    public static function getProperties() : array
    {
        return array_keys(get_class_vars(self::class));
    }
}
