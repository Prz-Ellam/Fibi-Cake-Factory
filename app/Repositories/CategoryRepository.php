<?php

namespace CakeFactory\Repositories;

use CakeFactory\Models\Category;

class CategoryRepository
{
    public function create(Category $category) : bool
    {
        return true;
    }

    public function update(Category $category) : bool
    {
        return true;
    }

    public function delete(Category $category) : bool
    {
        return true;
    }

    public function getAll()
    {

    }
}

?>