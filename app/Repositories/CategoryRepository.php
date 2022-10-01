<?php

namespace CakeFactory\Repositories;

use CakeFactory\Models\Category;
use Fibi\Database\DB;
use Fibi\Helpers\Parser;

class CategoryRepository
{
    private const CREATE = "CALL sp_create_category(:categoryId, :name, :description, :userId)";
    private const UPDATE = "CALL sp_update_category(:categoryId, :name, :description)";
    private const DELETE = "CALL sp_delete_category(:categoryId)";
    private const GET_ALL = "CALL sp_get_categories()";
    private const GET_ALL_BY_PRODUCT = "";

    public function create(Category $category) : bool
    {
        $parameters = Parser::SP(self::CREATE);
        $result = DB::executeNonQuery(self::CREATE, $category->toObject($parameters));
        return $result > 0;
    }

    public function update(Category $category) : bool
    {
        $parameters = Parser::SP(self::UPDATE);
        $result = DB::executeNonQuery(self::UPDATE, $category->toObject($parameters));
        return $result > 0;
    }

    public function delete(string $categoryId) : bool
    {
        $result = DB::executeNonQuery(self::DELETE, [
            "categoryId"        => $categoryId
        ]);

        return $result > 0;
    }

    public function getAll() : array
    {
        return DB::executeReader(self::GET_ALL);
    }

    public function getAllByProduct(string $productId) : array
    {
        return [];
    }
}

?>