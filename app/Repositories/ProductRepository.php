<?php

namespace CakeFactory\Repositories;

use CakeFactory\Models\Product;
use Fibi\Database\MainConnection;
use Fibi\Http\Request;
use Fibi\Http\Response;

class ProductRepository
{
    private MainConnection $connection;
    private const CREATE_PRODUCT = "CALL sp_create_product(:productId, :name, :description, :isQuotable, :price, :stock, :userId)";
    private const DELETE_PRODUCT = "CALL sp_delete_product(:productId)";
    private const GET_USER_PRODUCTS = "CALL sp_get_user_products(:userId)";
    private const GET_PRODUCT = "CALL sp_get_product(:productId)";

    public function __construct() {
        $this->connection = new MainConnection();
    }

    public function create(Product $product) : bool
    {
        $result = $this->connection->executeNonQuery(self::CREATE_PRODUCT, [
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

        return false;
    }

    public function delete(string $productId) : bool
    {
        $result = $this->connection->executeNonQuery(self::DELETE_PRODUCT, [
            "productId"     => $productId
        ]);

        return $result > 0;
    }

    public function getProduct(string $productId)
    {
        $result = $this->connection->executeReader(self::GET_PRODUCT, [
            "productId" => $productId
        ]);

        return $result;
    }

    public function getUserProducts(string $userId)
    {
        $result = $this->connection->executeReader(self::GET_USER_PRODUCTS, [
            "userId" => $userId
        ]);

        return $result;
    }
}

?>