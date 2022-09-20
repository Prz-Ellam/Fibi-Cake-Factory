<?php

namespace CakeFactory\Models;

use Fibi\Model\Model;

class Category extends Model
{
    private ?string $categoryId;
    private ?string $name;
    private ?string $description;
    private ?string $userId;

    public function getCategoryId() : ?string
    {
        return $this->categoryId;
    }

    public function setCategoryId(?string $categoryId) : self
    {
        $this->categoryId = $categoryId;
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

    public function getDescription() : ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description) : self
    {
        $this->description = $description;
        return $this;
    }

    public function getUserId() : ?string
    {
        return $this->userId;
    }

    public function setUserId(?string $userId) : self
    {
        $this->userId = $userId;
        return $this;
    }

    public function toObject()
    {
        $members = get_object_vars($this);
        return json_decode(json_encode($members), true);
    }
}

?>