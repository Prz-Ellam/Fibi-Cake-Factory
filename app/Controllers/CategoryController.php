<?php

namespace CakeFactory\Controllers;

use CakeFactory\Models\Category;
use CakeFactory\Repositories\CategoryRepository;
use Fibi\Http\Request;
use Fibi\Http\Response;
use Fibi\Session\PhpSession;
use Fibi\Validation\Validator;
use Ramsey\Uuid\Uuid;

class CategoryController
{
    /**
     * Crea una categoria
     * endpoint: POST api/v1/categories
     * Creado por: Eliam Rodriguez Perez
     * Creado: 2022-09-26
     *
     * @param Request $request
     * @param Response $response
     * @return void
     */
    public function create(Request $request, Response $response)
    {
        $categoryId = Uuid::uuid4()->toString();
        $name = $request->getBody('name');
        $description = $request->getBody('description');
        $userId = (new PhpSession())->get('user_id');

        if (is_null($userId))
        {
            $response->setStatusCode(401)->json([
                "status" => "Not authorized"
            ]);
            return;
        }

        $category = new Category();
        $category
            ->setCategoryId($categoryId)
            ->setName($name)
            ->setDescription($description)
            ->setUserId($userId);

        $validator = new Validator($category);
        $feedback = $validator->validate();
        $status = $validator->getStatus();

        if ($status === false)
        {
            $response->setStatusCode(400)->json([
                "status" => $status,
                "data" => $feedback
            ]);
            return;
        }

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

    /**
     * Undocumented function
     *
     * @param Request $request
     * @param Response $response
     * @return void
     */
    public function update(Request $request, Response $response)
    {
        // TODO: Solo un usuario administrador puede actualizar
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

        $validator = new Validator($category);
        $feedback = $validator->validate();

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

    /**
     * Undocumented function
     *
     * @param Request $request
     * @param Response $response
     * @return void
     */
    public function delete(Request $request, Response $response)
    {
        // TODO: Solo un usuario administrador puede eliminar
        $categoryId = $request->getRouteParams("categoryId");

        // Validar el category Id

        $categoryRepository = new CategoryRepository();
        $result = $categoryRepository->delete($categoryId);

        $response->json([
            "status" => $result
        ]);
    }

    public function getCategories(Request $request, Response $response)
    {
        $categoryRepository = new CategoryRepository();
        $result = $categoryRepository->getCategories();
        $response->json($result);
    }
}

?>