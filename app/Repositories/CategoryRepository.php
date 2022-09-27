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

    public function delete(Category $category) : bool
    {
        $parameters = Parser::SP(self::DELETE);
        $result = DB::executeNonQuery(self::DELETE, [
            "categoryId"        => $category->getCategoryId()
        ]);

        return $result > 0;
    }

    public function getCategories()
    {
        $result = DB::executeReader(self::GET_ALL);
        return $result;
    }
}

?>