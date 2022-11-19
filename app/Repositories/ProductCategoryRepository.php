<?php

namespace CakeFactory\Repositories;

use CakeFactory\Models\ProductCategory;
use Fibi\Database\DB;

class ProductCategoryRepository
{
    private const CREATE = "CALL sp_create_product_category(:productCategoryId, :productId, :categoryId)";
    private const DELETE = "";

    public function create(ProductCategory $productCategory)
    {
        $result = DB::executeNonQuery(self::CREATE, [
            "productCategoryId"     => $productCategory->getProductCategoryId(),
            "productId"             => $productCategory->getProductId(),
            "categoryId"            => $productCategory->getCategoryId()
        ]);

        return $result > 0;
    }

    
}
