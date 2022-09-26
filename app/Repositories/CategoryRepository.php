<?php

namespace CakeFactory\Repositories;

use CakeFactory\Models\Category;
use Fibi\Database\DB;

class CategoryRepository
{
    private const CREATE = "CALL sp_create_category(:categoryId, :name, :description, :userId)";
    private const UPDATE = "CALL sp_update_category(:categoryId, :name, :description)";
    private const DELETE = "CALL sp_delete_category(:categoryId)";
    private const GET_CATEGORIES = "CALL sp_get_categories()";

    public function create(Category $category) : bool
    {
        $result = DB::executeNonQuery(self::CREATE, [
            "categoryId"        => $category->getCategoryId(),
            "name"              => $category->getName(),
            "description"       => $category->getDescription(),
            "userId"            => $category->getUserId()
        ]);

        return $result > 0;
    }

    public function update(Category $category) : bool
    {
        $result = DB::executeNonQuery(self::UPDATE, [
            "categoryId"        => $category->getCategoryId(),
            "name"              => $category->getName(),
            "description"       => $category->getDescription()
        ]);

        return $result > 0;
    }

    public function delete(Category $category) : bool
    {
        $result = DB::executeNonQuery(self::DELETE, [
            "categoryId"        => $category->getCategoryId()
        ]);

        return $result > 0;
    }

    public function getCategories()
    {
        $result = DB::executeReader(self::GET_CATEGORIES, []);
        return $result;
    }
}

?>