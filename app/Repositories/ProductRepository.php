<?php

namespace CakeFactory\Repositories;

use CakeFactory\Models\Product;
use Fibi\Database\DB;
use Fibi\Helpers\Parser;

class ProductRepository
{
    private const CREATE = "CALL sp_products_create(:productId, :name, :description, :isQuotable, :price, :stock, :userId)";
    
    private const GET_USER_ID = "CALL sp_products_get_user_id(:productId)";
    
    private const UPDATE = "CALL sp_products_update(:productId, :name, :description, :isQuotable, :price, :stock)";
    private const DELETE = "CALL sp_products_delete(:productId)";
    private const GET_USER_PRODUCTS = "CALL sp_get_user_products(:userId, :clientId)";
    private const GET_ONE = "CALL sp_get_product(:productId, :userId)";
    private const FIND_ALL_BY_PENDING = "CALL sp_get_pending_products()";

    private const APPROVE = "CALL sp_product_approve(:productId, :userId)";
    private const DENIED = "CALL sp_product_denied(:productId, :userId)";

    private const GET_ALL_BY_USER_APPROVE = "CALL sp_get_user_products_approved(:userId)";
    private const GET_ALL_BY_USER_DENIED = "CALL sp_get_user_products_denied(:userId)";
    private const GET_ALL_BY_USER_PENDING = "CALL sp_get_user_products_pending(:userId)";
    // GET_ALL_BY_ADMIN_APPROVE
    private const GET_ALL_BY_RECENT = "CALL sp_products_get_all_by_recents(:userId)";
    private const GET_ALL_BY_ALPHA = "CALL sp_products_get_all_by_alpha(:order, :filter, :limit, :offset, :categoryId, :userId)";
    private const GET_ALL_BY_RATE = "CALL sp_products_get_all_by_rate(:order, :filter, :limit, :offset, :categoryId, :userId)";
    private const GET_ALL_BY_PRICE = "CALL sp_products_get_all_by_price(:order, :filter, :limit, :offset, :categoryId, :userId)";
    private const GET_ALL_BY_SHIPS = "CALL sp_products_get_all_by_ships(:order, :filter, :limit, :offset, :categoryId, :userId)";
    private const GET_ALL_BY_CATEGORY = "CALL sp_products_get_all_by_category";
    private const GET_ALL_BY_USER_FAVORITES = "CALL sp_products_get_user_favorites(:userId)";

    private const GET_ALL_BY_APPROVED_BY = "CALL sp_products_get_all_by_approved_by(:approved_by)";

    /**
     * Guarda un producto en la base de datos
     *
     * @param Product $product
     * @return boolean
     */
    public function create(Product $product) : bool
    {
        return DB::executeNonQuery(self::CREATE, [
            "productId"     => $product->getProductId(),
            "name"          => $product->getName(),
            "description"   => $product->getDescription(),
            "isQuotable"    => $product->getTypeOfSell(),
            "price"         => $product->getPrice(),
            "stock"         => $product->getStock(),
            "userId"        => $product->getUserId()
        ]) > 0;
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

    public function getProduct(string $productId, string $userId)
    {
        $result = DB::executeReader(self::GET_ONE, [
            "productId" => $productId,
            "userId" => $userId
        ]);

        return $result;
    }

    public function getUserProducts(string $userId, string $clientId)
    {
        $result = DB::executeReader(self::GET_USER_PRODUCTS, [
            "userId" => $userId,
            "clientId" => $clientId
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

    public function getAllByRecent(string $userId)
    {
        return DB::executeReader(self::GET_ALL_BY_RECENT, [
            "userId"        => $userId
        ]) ?? [];
    }

    public function getAllByAlpha(string $userId, string $order = "asc", ?string $filter = null, ?string $category = null) : array
    {
        return DB::executeReader(self::GET_ALL_BY_ALPHA, [
            "userId" => $userId,
            "order" => $order,
            "filter" => $filter,
            "limit" => null,
            "offset" => null,
            "categoryId" => $category
        ]);
    }

    public function getAllByRate(string $userId, string $order = "asc", ?string $filter = null, ?string $category = null) : array
    {
        return DB::executeReader(self::GET_ALL_BY_RATE, [
            "userId" => $userId,
            "order" => $order,
            "filter" => $filter,
            "limit" => null,
            "offset" => null,
            "categoryId" => $category
        ]);
    }

    public function getAllByPrice(string $userId, string $order = "asc", ?string $filter = null, ?string $category = null) : array
    {
        return DB::executeReader(self::GET_ALL_BY_PRICE, [
            "userId" => $userId,
            "order" => $order,
            "filter" => $filter,
            "limit" => null,
            "offset" => null,
            "categoryId" => $category
        ]);
    }

    public function getAllByShips(string $userId, string $order = "asc", ?string $filter = null, ?string $category = null) : array
    {
        return DB::executeReader(self::GET_ALL_BY_SHIPS, [
            "order" => $order,
            "filter" => $filter,
            "limit" => null,
            "offset" => null,
            "categoryId" => $category,
            "userId" => $userId
        ]);
    }

    public function getAllByApprovedBy(string $approvedBy) : array
    {
        return DB::executeReader(self::GET_ALL_BY_APPROVED_BY, [
            "approved_by" => $approvedBy
        ]);
    }

    public function getAllByUserFavorites(string $userId): array
    {
        return DB::executeReader(self::GET_ALL_BY_USER_FAVORITES, [
            "userId" => $userId
        ]);
    }

    public function getProductUserId(string $productId) : ?string
    {
        $result = DB::executeReader(self::GET_USER_ID, [
            "productId" => $productId
        ]);

        return $result[0]["user_id"] ?? "";
    }
}
