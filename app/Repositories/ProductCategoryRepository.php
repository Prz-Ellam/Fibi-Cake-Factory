<?php

namespace CakeFactory\Repositories;

use CakeFactory\Models\ProductCategory;
use Fibi\Database\DB;

class ProductCategoryRepository
{
    private const CREATE_PRODUCT_CATEGORY = "CALL sp_create_product_category(:productCategoryId, :productId, :categoryId)";

    public function create(ProductCategory $productCategory)
    {
        $result = DB::executeNonQuery(self::CREATE_PRODUCT_CATEGORY, [
            "productCategoryId"     => $productCategory->getProductCategoryId(),
            "productId"             => $productCategory->getProductId(),
            "categoryId"            => $productCategory->getCategoryId()
        ]);

        return $result > 0;
    }

    
}

?>