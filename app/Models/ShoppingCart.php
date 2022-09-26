<?php

namespace CakeFactory\Models;

class ShoppingCart
{
    private ?string $shoppingCartId;
    private ?string $userId;

    public function getShoppingCartId() : ?string
    {
        return $this->shoppingCartId;
    }

    public function setShoppingCartId(?string $shoppingCartId) : self
    {
        $this->shoppingCartId = $shoppingCartId;
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