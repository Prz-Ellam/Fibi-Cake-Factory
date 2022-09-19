<?php

namespace CakeFactory\Controllers;

use CakeFactory\Models\Category;
use CakeFactory\Repositories\CategoryRepository;
use CakeFactory\Validators\CategoryValidator;
use Fibi\Http\Request;
use Fibi\Http\Response;

class CategoryController
{
    public function create(Request $request, Response $response)
    {
        $name = $request->getBody('name');
        $description = $request->getBody('description');

        $category = new Category();
        $category->setName($name)
            ->setDescription($description);

        $validator = new CategoryValidator($category);
        $result = $validator->validate();

        $repository = new CategoryRepository();

        $response->json(["res" => $result]);
    }

    public function update(Request $request, Response $response)
    {

    }

    public function delete(Request $request, Response $response)
    {

    }
}

?>