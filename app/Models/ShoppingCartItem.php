<?php

namespace CakeFactory\Models;

use Fibi\Model\Model;

class ShoppingCartItem extends Model
{
    private ?string $shoppingCartItemId;
    private ?string $shoppingCartId;
    private ?string $productId;
    private ?int $quantity;

    public function getShoppingCartItemId() : ?string
    {
        return $this->shoppingCartItemId;
    }

    public function setShoppingCartItemId(?string $shoppingCartItemId) : self
    {
        $this->shoppingCartItemId = $shoppingCartItemId;
        return $this;
    }

    public function getShoppingCartId() : ?string
    {
        return $this->shoppingCartId;
    }

    public function setShoppingCartId(?string $shoppingCartId) : self
    {
        $this->shoppingCartId = $shoppingCartId;
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
        $this->quantity= $quantity;
        return $this;
    }
}

?>