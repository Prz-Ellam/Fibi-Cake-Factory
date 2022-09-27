<?php

namespace CakeFactory\Controllers;

use CakeFactory\Models\Category;
use CakeFactory\Repositories\CategoryRepository;
use CakeFactory\Validators\CategoryValidator;
use Fibi\Http\Request;
use Fibi\Http\Response;
use Fibi\Session\PhpSession;
use Fibi\Validation\Validator;
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

        $validator = new Validator($category);
        $result = $validator->validate();

        $categoryRepository = new CategoryRepository();
        $result = $categoryRepository->create($category);

        $response->json([
            "status" => $result,
            "data" => [
                "id" => $categoryId,
                "name" => $name,
                "description" => $description
            ]
        ]);
    }

    public function update(Request $request, Response $response)
    {
        $categoryId = $request->getRouteParams('categoryId');
        $name = $request->getBody('name');
        $description = $request->getBody('description');
        $userId = $request->getBody("user-id");
        if (is_null($userId))
            $userId = (new PhpSession())->get('user_id');

        $category = new Category();
        $category->setCategoryId($categoryId)
            ->setName($name)
            ->setDescription($description)
            ->setUserId($userId);

        $validator = new CategoryValidator($category);
        $result = $validator->validate();

        $categoryRepository = new CategoryRepository();
        $result = $categoryRepository->update($category);

        $response->json([
            "status" => $result,
            "data" => [
                "id" => $categoryId,
                "name" => $name,
                "description" => $description
            ]
        ]);
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