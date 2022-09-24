<?php

namespace CakeFactory\Models;

class Product
{
    private ?string $productId;
    private ?string $name;
    private ?string $description;
    private ?int $typeOfSell;
    private ?int $stock;
    private ?float $price;
    private ?string $userId;

    public function getProductId() : ?string
    {
        return $this->productId;
    }

    public function setProductId(?string $productId) : self
    {
        $this->productId = $productId;
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

    public function getTypeOfSell() : ?int
    {
        return $this->typeOfSell;
    }

    public function setTypeOfSell(?int $typeOfSell) : self
    {
        $this->typeOfSell = $typeOfSell;
        return $this;
    }

    public function getPrice() : ?float
    {
        return $this->price;
    }

    public function setPrice(?float $price) : self
    {
        $this->price = $price;
        return $this;
    }

    public function getStock() : ?int
    {
        return $this->stock;
    }

    public function setStock(?int $stock) : self
    {
        $this->stock = $stock;
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
}

?>