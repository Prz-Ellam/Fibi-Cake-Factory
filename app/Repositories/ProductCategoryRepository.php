<?php

namespace CakeFactory\Repositories;

use CakeFactory\Models\ProductCategory;
use Fibi\Database\MainConnection;

class ProductCategoryRepository
{
    private MainConnection $connection;
    private const CREATE_PRODUCT_CATEGORY = "CALL sp_create_product_category(:productCategoryId, :productId, :categoryId)";

    public function __construct() {
        $this->connection = new MainConnection();
    }

    public function create(ProductCategory $productCategory)
    {
        $result = $this->connection->executeNonQuery(self::CREATE_PRODUCT_CATEGORY, [
            "productCategoryId"     => $productCategory->getProductCategoryId(),
            "productId"             => $productCategory->getProductId(),
            "categoryId"            => $productCategory->getCategoryId()
        ]);

        return $result > 0;
    }

    
}

?>