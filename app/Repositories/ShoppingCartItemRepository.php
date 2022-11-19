<?php

namespace CakeFactory\Repositories;

use CakeFactory\Models\ShoppingCartItem;
use Fibi\Database\DB;

class ShoppingCartItemRepository
{
    private const CREATE = "CALL sp_add_shopping_cart_item(:shoppingCartItemId, :shoppingCartId, :productId, :quantity)";
    private const UPDATE = "CALL sp_update_shopping_cart_item(:shoppingCartItemId, :quantity)";
    private const DELETE = "CALL sp_delete_shopping_cart_item(:shoppingCartItemId)";
    private const GET_ALL_BY_SHOPPING_CART = "CALL sp_get_shopping_cart_items(:shoppingCartId)";
    private const GET_QUANTITY = "CALL sp_shopping_cart_items_get_quantity(:shoppingCartItemId)";
    private const GET_PRODUCT_ID = "CALL sp_shopping_cart_item_get_product_id(:shoppingCartItemId)";
    // GET_ALL_BY_SHOPPING_CART

    public function addShoppingCartItem(ShoppingCartItem $shoppingCartItem)
    {
        $result = DB::executeNonQuery(self::CREATE, [
            "shoppingCartItemId"        => $shoppingCartItem->getShoppingCartItemId(),
            "shoppingCartId"            => $shoppingCartItem->getShoppingCartId(),
            "productId"                 => $shoppingCartItem->getProductId(),
            "quantity"                  => $shoppingCartItem->getQuantity()
        ]);

        return $result;
    }

    public function update(ShoppingCartItem $shoppingCartItem): bool
    {
        return DB::executeNonQuery(self::UPDATE, [
            "shoppingCartItemId"        => $shoppingCartItem->getShoppingCartItemId(),
            "quantity"                  => $shoppingCartItem->getQuantity()
        ]) > 0;
    }

    public function getShoppingCartItems(string $shoppingCartId)
    {
        $result = DB::executeReader(self::GET_ALL_BY_SHOPPING_CART, [
            "shoppingCartId"        => $shoppingCartId
        ]);

        return $result;
    }

    public function removeShoppingCartItem(string $shoppingCartItemId)
    {
        $result = DB::executeNonQuery(self::DELETE, [
            "shoppingCartItemId"        => $shoppingCartItemId
        ]);

        return $result;
    }

    public function getQuantity(string $shoppingCartItemId)
    {
        $result = DB::executeReader(self::GET_QUANTITY, [
            "shoppingCartItemId"        => $shoppingCartItemId
        ]);

        return $result[0]["quantity"] ?? null;
    }

    public function getProductId(string $shoppingCartItemId)
    {
        $result = DB::executeReader(self::GET_PRODUCT_ID, [
            "shoppingCartItemId"        => $shoppingCartItemId
        ]);

        return $result[0]["product_id"] ?? null;
    }
}
