<?php

namespace CakeFactory\Models;

use Fibi\Model\Model;
use Fibi\Validation\Rules\Required;

class Wishlist implements Model
{
    /**
     * Undocumented variable
     *
     * @var string|null
     */
    #[Required]
    private ?string $wishlistId;

    /**
     * Undocumented variable
     *
     * @var string|null
     */
    #[Required]
    private ?string $name;

    /**
     * Undocumented variable
     *
     * @var string|null
     */
    #[Required]
    private ?string $description;

    /**
     * Undocumented variable
     *
     * @var integer|null
     */
    #[Required]
    private ?int $visible;

    /**
     * Undocumented variable
     *
     * @var string|null
     */
    #[Required]
    private ?string $userId;

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
        return $this->visible;
    }

    public function setVisibility(?int $visible) : self
    {
        $this->visible = $visible;
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