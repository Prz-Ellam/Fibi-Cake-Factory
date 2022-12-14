<?php

namespace CakeFactory\Repositories;

use CakeFactory\Models\ShoppingCart;
use Fibi\Database\DB;
use Fibi\Database\MainConnection;

class ShoppingCartRepository
{
    private const CREATE = "CALL sp_create_shopping_cart(:shoppingCartId, :userId)";
    private const DELETE = "CALL sp_delete_shopping_cart(:shoppingCartId)";
    private const GET_CART_BY_USER = "CALL sp_get_user_shopping_cart(:userId)";

    public function create(ShoppingCart $shoppingCart)
    {
        $result = DB::executeNonQuery(self::CREATE, [
            "shoppingCartId"    => $shoppingCart->getShoppingCartId(),
            "userId"            => $shoppingCart->getUserId()
        ]);

        return $result > 0;
    }

    public function getUserCart(string $userId) : ?string
    {
        $result = DB::executeReader(self::GET_CART_BY_USER, [
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
        $result = DB::executeNonQuery(self::DELETE, [
            "shoppingCartId"    => $shoppingCartId
        ]);

        return $result > 0;
    }
}
