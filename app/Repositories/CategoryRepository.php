<?php

namespace CakeFactory\Repositories;

use CakeFactory\Models\Category;
use Fibi\Database\MainConnection;

class CategoryRepository
{
    private MainConnection $connection;
    private const CREATE_CATEGORY = "CALL sp_create_category(:categoryId, :name, :description, :userId)";
    private const UPDATE_CATEGORY = "";
    private const DELETE_CATEGORY = "";
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
        return true;
    }

    public function delete(Category $category) : bool
    {
        return true;
    }

    public function getCategories()
    {
        $result = $this->connection->executeReader(self::GET_CATEGORIES, []);
        return $result;
    }
}

?>