<?php

namespace CakeFactory\Repositories;

use CakeFactory\Models\Product;
use Fibi\Database\DB;
use Fibi\Helpers\Parser;

class ProductRepository
{
    private const CREATE = "CALL sp_create_product(:productId, :name, :description, :isQuotable, :price, :stock, :userId)";
    private const UPDATE = "CALL sp_update_product(:productId, :name, :description, :isQuotable, :price, :stock)";
    private const DELETE = "CALL sp_delete_product(:productId)";
    private const GET_USER_PRODUCTS = "CALL sp_get_user_products(:userId)";
    private const GET_ONE = "CALL sp_get_product(:productId)";
    private const GET_RECENT_PRODUCTS = "CALL sp_get_recent_products()";
    private const FIND_ALL_BY_PENDING = "CALL sp_get_pending_products()";

    private const APPROVE = "CALL sp_product_approve(:productId, :userId)";
    private const DENIED = "CALL sp_product_denied(:productId, :userId)";

    private const GET_ALL_BY_USER_APPROVE = "CALL sp_get_user_products_approved(:userId)";
    private const GET_ALL_BY_USER_DENIED = "CALL sp_get_user_products_denied(:userId)";
    private const GET_ALL_BY_USER_PENDING = "CALL sp_get_user_products_pending(:userId)";
    // GET_ALL_BY_ADMIN_APPROVE
    private const GET_ALL_BY_ALPHA = "CALL sp_products_get_all_by_alpha(:order, :filter, :limit, :offset)";
    private const GET_ALL_BY_RATE = "CALL sp_products_get_all_by_rate(:order, :filter, :limit, :offset)";
    private const GET_ALL_BY_PRICE = "CALL sp_products_get_all_by_price(:order, :filter, :limit, :offset)";
    private const GET_ALL_BY_SHIPS = "CALL sp_products_get_all_by_ships(:order, :filter, :limit, :offset)";
    private const GET_ALL_BY_CATEGORY = "CALL sp_products_get_all_by_category";
    private const GET_ALL_BY_USER_RECOMENDATIONS = "CALL sp_products_get_all_by_user_recomendations";

    public function create(Product $product) : bool
    {
        $parameters = Parser::SP(self::CREATE);
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
        $parameters = Parser::SP(self::UPDATE);
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
        $result = DB::executeReader(self::GET_ONE, [
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

    public function getAllByUserApprove(string $userId)
    {
        return DB::executeReader(self::GET_ALL_BY_USER_APPROVE, [
            "userId" => $userId
        ]);
    }

    public function getAllByUserDenied(string $userId)
    {
        return DB::executeReader(self::GET_ALL_BY_USER_DENIED, [
            "userId" => $userId
        ]);
    }

    public function getAllByUserPending(string $userId)
    {
        return DB::executeReader(self::GET_ALL_BY_USER_PENDING, [
            "userId" => $userId
        ]);
    }

    public function getRecentProducts()
    {
        $result = DB::executeReader(self::GET_RECENT_PRODUCTS, []);
        return $result;
    }

    public function findAllByPending() : array
    {
        return DB::executeReader(self::FIND_ALL_BY_PENDING);
    }

    public function approve(string $productId, string $userId) : bool
    {
        return DB::executeNonQuery(self::APPROVE, [
            "productId" => $productId,
            "userId" => $userId
        ]) > 0;
    }

    public function denied(string $productId, string $userId) : bool
    {
        return DB::executeNonQuery(self::DENIED, [
            "productId" => $productId,
            "userId" => $userId
        ]) > 0;
    }

    public function getAllByAlpha() : array
    {
        return DB::executeReader(self::GET_ALL_BY_ALPHA, [
            "order" => "asc",
            "filter" => null,
            "limit" => null,
            "offset" => null
        ]);
    }

    public function getAllByRate() : array
    {
        return DB::executeReader(self::GET_ALL_BY_RATE, [
            "order" => "asc",
            "filter" => null,
            "limit" => null,
            "offset" => null
        ]);
    }

    public function getAllByPrice() : array
    {
        return DB::executeReader(self::GET_ALL_BY_PRICE, [
            "order" => "asc",
            "filter" => null,
            "limit" => null,
            "offset" => null
        ]);
    }

    public function getAllByShips() : array
    {
        return DB::executeReader(self::GET_ALL_BY_SHIPS, [
            "order" => "asc",
            "filter" => null,
            "limit" => null,
            "offset" => null
        ]);
    }
}

?>