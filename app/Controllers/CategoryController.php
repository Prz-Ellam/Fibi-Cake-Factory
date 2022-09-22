<?php

namespace CakeFactory\Controllers;

use CakeFactory\Models\Category;
use CakeFactory\Repositories\CategoryRepository;
use CakeFactory\Validators\CategoryValidator;
use Fibi\Http\Request;
use Fibi\Http\Response;
use Fibi\Session\PhpSession;
use Ramsey\Uuid\Uuid;

class CategoryController
{
    public function create(Request $request, Response $response)
    {
        $categoryId = Uuid::uuid4()->toString();
        $name = $request->getBody('name');
        $description = $request->getBody('description');
        $userId = (new PhpSession())->get('user_id');

        $category = new Category();
        $category->setCategoryId($categoryId)
            ->setName($name)
            ->setDescription($description)
            ->setUserId($userId);

        $validator = new CategoryValidator($category);
        $result = $validator->validate();

        $categoryRepository = new CategoryRepository();
        $categoryRepository->create($category);

        $response->json(["response" => $result]);
    }

    public function update(Request $request, Response $response)
    {

    }

    public function delete(Request $request, Response $response)
    {

    }

    public function getCategories(Request $request, Response $response)
    {
        $categoryRepository = new CategoryRepository();
        $result = $categoryRepository->getCategories();
        $response->json($result);
    }
}

?>