<?php

namespace CakeFactory\Repositories;

use CakeFactory\Models\Shopping;
use Fibi\Database\DB;

class ShoppingRepository
{
    private const CREATE_SHOPPING = "CALL sp_create_shopping(:shoppingId, :orderId, :productId, :quantity, :amount)";

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

}

?>