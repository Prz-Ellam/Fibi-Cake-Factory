<?php

namespace CakeFactory\Models;

class Wishlist
{
    private ?string $wishlistId;
    private ?string $name;
    private ?string $description;
    private ?int $visibility;

    public function getWishlistId() : ?string
    {
        return $this->wishlistId;
    }

    public function setWishlistId(?string $wishlistId) : self
    {
        $this->wishlistId = $wishlistId;
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

    public function getVisibility() : ?int
    {
        return $this->visibility;
    }
}

?>