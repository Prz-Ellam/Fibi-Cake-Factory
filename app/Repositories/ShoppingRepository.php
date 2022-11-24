<?php

namespace CakeFactory\Repositories;

use CakeFactory\Models\Shopping;
use Fibi\Database\DB;

class ShoppingRepository
{
    private const CREATE_SHOPPING = "CALL sp_create_shopping(:shoppingId, :orderId, :productId, :quantity, :amount)";
    private const EXISTS = "CALL sp_shoppings_exists(:productId, :userId)";

    public function create(Shopping $shopping) : bool
    {
        $result = DB::executeNonQuery(self::CREATE_SHOPPING, [
            "shoppingId"        => $shopping->getShoppingId(),
            "orderId"           => $shopping->getOrderId(),
            "productId"         => $shopping->getProductId(),
            "quantity"          => $shopping->getQuantity(),
            "amount"            => $shopping->getAmount()
        ]);

        return $result > 0;
    }

    public function exists(string $productId, string $userId): bool
    {
        $result = DB::executeReader(self::EXISTS, [
            "productId"         => $productId,
            "userId"            => $userId
        ]);
        return $result[0]["status"] ?? false;
    }

}
