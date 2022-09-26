<?php

namespace CakeFactory\Models;

class Shopping
{
    private ?string $shoppingId;
    private ?string $orderId;
    private ?string $productId;
    private ?int $quantity;
    private ?float $amount;

    public function getShoppingId() : ?string
    {
        return $this->shoppingId;
    }

    public function setShoppingId(?string $shoppingId) : self
    {
        $this->shoppingId = $shoppingId;
        return $this;
    }

    public function getOrderId() : ?String
    {
        return $this->orderId;
    }

    public function setOrderId(?string $orderId) : self
    {
        $this->orderId = $orderId;
        return $this;
    }

    public function getProductId() : ?string
    {
        return $this->productId;
    }

    public function setProductId(?string $productId) : self
    {
        $this->productId = $productId;
        return $this;
    }

    public function getQuantity() : ?int
    {
        return $this->quantity;
    }

    public function setQuantity(?int $quantity) : self
    {
        $this->quantity = $quantity;
        return $this;
    }

    public function getAmount() : ?float
    {
        return $this->amount;
    }

    public function setAmount(?int $amount) : self
    {
        $this->amount = $amount;
        return $this;
    }

}

?>