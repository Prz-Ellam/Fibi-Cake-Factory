<?php

namespace CakeFactory\Repositories;

use CakeFactory\Models\Product;
use Fibi\Database\DB;

class ProductRepository
{
    private const CREATE = "CALL sp_create_product(:productId, :name, :description, :isQuotable, :price, :stock, :userId)";
    private const UPDATE = "CALL sp_update_product(:productId, :name, :description, :isQuotable, :price, :stock)";
    private const DELETE = "CALL sp_delete_product(:productId)";
    private const GET_USER_PRODUCTS = "CALL sp_get_user_products(:userId)";
    private const GET_PRODUCT = "CALL sp_get_product(:productId)";
    private const GET_RECENT_PRODUCTS = "CALL sp_get_recent_products()";
    // GET_ALL_BY_CATEGORY
    // GET_ALL_BY_USER
    // GET_ALL_BY_USER_APPROVE
    // GET_ALL_BY_ADMIN_APPROVE
    // GET_ALL_BY_RATE
    // GET_ALL_BY_PRICE
    // GET_ALL_BY_USER_FAVORITES
    // GET_ALL_BY_USER_RECOMENDATIONS
    // APPROVE_PRODUCT (:userId)
    // DENIED_PRODUCT (:userId)

    public function create(Product $product) : bool
    {
        $result = DB::executeNonQuery(self::CREATE, [
            "productId"     => $product->getProductId(),
            "name"          => $product->getName(),
            "description"   => $product->getDescription(),
            "isQuotable"    => $product->getTypeOfSell(),
            "price"         => $product->getPrice(),
            "stock"         => $product->getStock(),
            "userId"        => $product->getUserId()
        ]);

        return $result > 0;
    }

    public function update(Product $product) : bool
    {
        $result = DB::executeNonQuery(self::UPDATE, [
            "productId"     => $product->getProductId(),
            "name"          => $product->getName(),
            "description"   => $product->getDescription(),
            "isQuotable"    => $product->getTypeOfSell(),
            "price"         => $product->getPrice(),
            "stock"         => $product->getStock()
        ]);

        return $result > 0;
    }

    public function delete(string $productId) : bool
    {
        $result = DB::executeNonQuery(self::DELETE, [
            "productId"     => $productId
        ]);

        return $result > 0;
    }

    public function getProduct(string $productId)
    {
        $result = DB::executeReader(self::GET_PRODUCT, [
            "productId" => $productId
        ]);

        return $result;
    }

    public function getUserProducts(string $userId)
    {
        $result = DB::executeReader(self::GET_USER_PRODUCTS, [
            "userId" => $userId
        ]);

        return $result;
    }

    public function getRecentProducts()
    {
        $result = DB::executeReader(self::GET_RECENT_PRODUCTS, []);
        return $result;
    }
}

?>