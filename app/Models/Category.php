<?php

namespace CakeFactory\Models;

use Fibi\Model\Model;

class Category extends Model
{
    private ?int $categoryId;
    private ?string $name;
    private ?string $description;

    public function getCategoryId() : ?int
    {
        return $this->categoryId;
    }

    public function setCategoryId(?int $categoryId) : self
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

    public function toObject()
    {
        $members = get_object_vars($this);
        return json_decode(json_encode($members), true);
    }
}

?>