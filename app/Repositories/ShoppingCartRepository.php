<?php

namespace CakeFactory\Repositories;

use CakeFactory\Models\ShoppingCart;
use Fibi\Database\MainConnection;

class ShoppingCartRepository
{
    private MainConnection $connection;
    private const CREATE = "CALL sp_create_shopping_cart(:shoppingCartId, :userId)";
    private const GET_USER_CART = "CALL sp_get_user_shopping_cart(:userId)";
    private const DELETE_SHOPPING_CART = "CALL sp_delete_shopping_cart(:shoppingCartId)";

    public function __construct()
    {
        $this->connection = new MainConnection();
    }

    public function create(ShoppingCart $shoppingCart)
    {
        $result = $this->connection->executeNonQuery(self::CREATE, [
            "shoppingCartId"    => $shoppingCart->getShoppingCartId(),
            "userId"            => $shoppingCart->getUserId()
        ]);

        return $result > 0;
    }

    public function getUserCart(string $userId) : ?string
    {
        $result = $this->connection->executeReader(self::GET_USER_CART, [
            "userId"    => $userId
        ]);

        if (is_null($result))
        {
            return null;
        }

        return $result[0]["id"];
    }

    public function delete(string $shoppingCartId) : bool
    {
        $result = $this->connection->executeNonQuery(self::DELETE_SHOPPING_CART, [
            "shoppingCartId"    => $shoppingCartId
        ]);

        return $result > 0;
    }
}

?>