<?php

namespace CakeFactory\Models;

use Fibi\Model\Model;

class Shopping implements Model
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

    public function toObject() : array
    {
        $members = get_object_vars($this);
        return json_decode(json_encode($members), true);
    }

    public static function getProperties() : array
    {
        return array_keys(get_class_vars(self::class));
    }
}

?>