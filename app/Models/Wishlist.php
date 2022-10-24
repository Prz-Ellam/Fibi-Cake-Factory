<?php

namespace CakeFactory\Models;

use Fibi\Model\Model;
use Fibi\Validation\Rules\MaxLength;
use Fibi\Validation\Rules\Required;
use Fibi\Validation\Rules\Uuid;

class Wishlist implements Model
{
    /**
     * Undocumented variable
     *
     * @var string|null
     */
    #[Required]
    #[Uuid]
    private ?string $wishlistId = null;

    /**
     * Undocumented variable
     *
     * @var string|null
     */
    #[Required]
    #[MaxLength(50)]
    private ?string $name = null;

    /**
     * Undocumented variable
     *
     * @var string|null
     */
    #[Required]
    #[MaxLength(200)]
    private ?string $description = null;

    /**
     * Undocumented variable
     *
     * @var boolean|null
     */
    #[Required("La visibilidad no puede estar vacía")]
    private ?bool $visible = null;

    /**
     * Undocumented variable
     *
     * @var string|null
     */
    #[Required]
    #[Uuid]
    private ?string $userId = null;

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

    public function isVisible() : ?int
    {
        return $this->visible ? 1 : 0;
    }

    public function setVisible(?bool $visible) : self
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

    public function toObject(array $bind = null) : array
    {
        $members = get_object_vars($this);
        $members = json_decode(json_encode($members), true);

        if (is_null($bind) || count($bind) === 0)
        {
            return $members;
        }

        $members = array_filter($members, 
        function($key) use ($bind) { 
            return in_array($key, $bind); 
        }, ARRAY_FILTER_USE_KEY);

        return $members;
    }

    public static function getProperties() : array
    {
        return array_keys(get_class_vars(self::class));
    }
}
