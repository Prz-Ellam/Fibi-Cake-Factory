<?php

namespace CakeFactory\Repositories;

use CakeFactory\Models\ShoppingCartItem;
use Fibi\Database\MainConnection;

class ShoppingCartItemRepository
{
    private MainConnection $connection;
    private const ADD_SHOPPING_CART_ITEM = "CALL sp_add_shopping_cart_item(:shoppingCartItemId, :shoppingCartId, :productId, :quantity)";
    private const GET_SHOPPING_CART_ITEMS = "CALL sp_get_shopping_cart_items(:shoppingCartId)";
    private const REMOVE_SHOPPING_CART_ITEM = "CALL sp_delete_shopping_cart_item(:shoppingCartItemId)";

    public function __construct() {
        $this->connection = new MainConnection();
    }

    public function addShoppingCartItem(ShoppingCartItem $shoppingCartItem)
    {
        $result = $this->connection->executeNonQuery(self::ADD_SHOPPING_CART_ITEM, [
            "shoppingCartItemId"        => $shoppingCartItem->getShoppingCartItemId(),
            "shoppingCartId"            => $shoppingCartItem->getShoppingCartId(),
            "productId"                 => $shoppingCartItem->getProductId(),
            "quantity"                  => $shoppingCartItem->getQuantity()
        ]);

        return $result;
    }

    public function getShoppingCartItems(string $shoppingCartId)
    {
        $result = $this->connection->executeReader(self::GET_SHOPPING_CART_ITEMS, [
            "shoppingCartId"        => $shoppingCartId
        ]);

        return $result;
    }

    public function removeShoppingCartItem(string $shoppingCartItemId)
    {
        $result = $this->connection->executeNonQuery(self::REMOVE_SHOPPING_CART_ITEM, [
            "shoppingCartItemId"        => $shoppingCartItemId
        ]);

        return $result;
    }
}

?>