<?php

namespace CakeFactory\Repositories;

use CakeFactory\Models\Product;
use Fibi\Database\MainConnection;
use Fibi\Http\Request;
use Fibi\Http\Response;

class ProductRepository
{
    private MainConnection $connection;

    public function __construct() {
        $this->connection = new MainConnection();
    }

    public function create(Product $product) : bool
    {

        return false;
    }

    public function update(Product $product) : bool
    {

        return false;
    }

    public function delete(string $productId) : bool
    {
        
        return false;
    }

    public function getUserProducts(string $userId)
    {

    }
}

?>