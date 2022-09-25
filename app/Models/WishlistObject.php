<?php

namespace CakeFactory\Models;

use Fibi\Model\Model;

class WishlistObject extends Model
{
    private ?string $wishlistObjectId;
    private ?string $wishlistId;
    private ?string $productId;

    public function getWishlistObjectId() : ?string
    {
        return $this->wishlistObjectId;
    }

    public function setWishlistObjectId(?string $wishlistObjectId) : self
    {
        $this->wishlistObjectId = $wishlistObjectId;
        return $this;
    }

    public function getWishlistId() : ?string
    {
        return $this->wishlistId;
    }

    public function setWishlistId(?string $wishlistId) : self
    {
        $this->wishlistId = $wishlistId;
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
}

?>