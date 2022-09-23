<?php

namespace CakeFactory\Repositories;

use CakeFactory\Models\Category;
use Fibi\Database\MainConnection;

class CategoryRepository
{
    private MainConnection $connection;
    private const CREATE_CATEGORY = "CALL sp_create_category(:categoryId, :name, :description, :userId)";
    private const UPDATE_CATEGORY = "CALL sp_update_category(:categoryId, :name, :description)";
    private const DELETE_CATEGORY = "CALL sp_delete_category(:categoryId)";
    private const GET_CATEGORIES = "CALL sp_get_categories()";

    public function __construct() {
        $this->connection = new MainConnection();
    }

    public function create(Category $category) : bool
    {
        $result = $this->connection->executeNonQuery(self::CREATE_CATEGORY, [
            "categoryId"        => $category->getCategoryId(),
            "name"              => $category->getName(),
            "description"       => $category->getDescription(),
            "userId"            => $category->getUserId()
        ]);

        return $result > 0;
    }

    public function update(Category $category) : bool
    {
        $result = $this->connection->executeNonQuery(self::UPDATE_CATEGORY, [
            "categoryId"        => $category->getCategoryId(),
            "name"              => $category->getName(),
            "description"       => $category->getDescription()
        ]);

        return $result > 0;
    }

    public function delete(Category $category) : bool
    {
        $result = $this->connection->executeNonQuery(self::UPDATE_CATEGORY, [
            "categoryId"        => $category->getCategoryId()
        ]);

        return $result > 0;
    }

    public function getCategories()
    {
        $result = $this->connection->executeReader(self::GET_CATEGORIES, []);
        return $result;
    }
}

?>