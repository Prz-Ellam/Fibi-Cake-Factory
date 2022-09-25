<?php

namespace CakeFactory\Repositories;

use Fibi\Database\MainConnection;

class ShoppingCartRepository
{
    private MainConnection $connection;
    private const GET_USER_CART = "CALL sp_get_user_shopping_cart(:userId)";

    public function __construct()
    {
        $this->connection = new MainConnection();
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
}

?>