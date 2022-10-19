<?php

namespace CakeFactory\Models;

use Fibi\Model\Model;
use Fibi\Validation\Rules\Required;
use Fibi\Validation\Rules\Uuid;

class ShoppingCart implements Model
{
    /**
     * Identificador único del carrito de compras
     *
     * @var string|null
     */
    #[Required]
    #[Uuid]
    private ?string $shoppingCartId = null;
    
    /**
     * Identificador del usuario al que le pertenece el carrito
     *
     * @var string|null
     */
    #[Required]
    #[Uuid]
    private ?string $userId = null;

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