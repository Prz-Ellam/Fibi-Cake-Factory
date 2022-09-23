<?php

namespace CakeFactory\Repositories;

use CakeFactory\Models\ProductCategory;
use Fibi\Database\MainConnection;

class ProductCategoryRepository
{
    private MainConnection $connection;

    public function __construct() {
        $this->connection = new MainConnection();
    }

    public function create(ProductCategory $productCategory)
    {

    }

    
}

?>