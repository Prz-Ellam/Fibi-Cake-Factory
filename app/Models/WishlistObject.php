<?php

namespace CakeFactory\Models;

use Fibi\Model\Model;
use Fibi\Validation\Rules\Required;

class WishlistObject implements Model
{
    /**
     * Undocumented variable
     *
     * @var string|null
     */
    #[Required]
    private ?string $wishlistObjectId = null;

    /**
     * Undocumented variable
     *
     * @var string|null
     */
    #[Required]
    private ?string $wishlistId = null;

    /**
     * Undocumented variable
     *
     * @var string|null
     */
    #[Required]
    private ?string $productId = null;

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