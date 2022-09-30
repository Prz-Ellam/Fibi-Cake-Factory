<?php

namespace CakeFactory\Models;

use Fibi\Model\Model;
use Fibi\Validation\Rules\Required;
use Fibi\Validation\Rules\Uuid;

class ShoppingCartItem implements Model
{
    #[Required]
    #[Uuid]
    private ?string $shoppingCartItemId;

    #[Required]
    #[Uuid]
    private ?string $shoppingCartId;

    #[Required]
    #[Uuid]
    private ?string $productId;
    
    #[Required]
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