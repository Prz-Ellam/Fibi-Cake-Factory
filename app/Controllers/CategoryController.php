<?php

namespace CakeFactory\Controllers;

use CakeFactory\Models\Category;
use CakeFactory\Repositories\CategoryRepository;
use Fibi\Http\Controller;
use Fibi\Http\Request;
use Fibi\Http\Response;
use Fibi\Session\PhpSession;
use Fibi\Validation\Rules\Required;
use Fibi\Validation\Rules\Uuid as _Uuid;
use Fibi\Validation\Validator;
use Ramsey\Uuid\Uuid;

/**
 * Controlador de los endpoints de las categorias
 */
class CategoryController extends Controller
{
    /**
     * Crea una categoría
     * Endpoint: POST api/v1/categories
     * Creado por: Eliam Rodríguez Pérez
     * Creado: 2022-09-26
     *
     * @param Request $request
     * @param Response $response
     * @return void
     */
    public function create(Request $request, Response $response)
    {
        $session = new PhpSession();
        $userId = $session->get("userId");

        // TODO: Ponerle Not authorized en todos lados
        if (!$userId) {
            $response->setStatusCode(401)->json([
                "status" => false,
                "message" => "Not authorized"
            ]);
            return;
        }

        $categoryId = Uuid::uuid4()->toString();
        $name = $request->getBody("name");
        $description = $request->getBody("description");

        $category = new Category();
        $category
            ->setCategoryId($categoryId)
            ->setName($name)
            ->setDescription($description)
            ->setUserId($userId);

        $validator = new Validator($category);
        $feedback = $validator->validate();
        $status = $validator->getStatus();
        if (!$status) {
            $response->setStatusCode(400)->json([
                "status" => $status,
                "data" => $feedback
            ]);
            return;
        }

        $categoryRepository = new CategoryRepository();
        $result = $categoryRepository->create($category);
        if (!$result) {
            $response->setStatusCode(400)->json([
                "status" => $result,
                "data" => "No se pudo crear la categoría"
            ]);
            return;
        }

        $response->json([
            "status" => $result,
            "message" => "La categoría se creó exitosamente",
            "data" => [
                "id" => $categoryId,
                "name" => $name,
                "description" => $description
            ]
        ]);
    }

    /**
     * Actualiza una categoría
     * Endpoint: PUT api/v1/categories/:categoryId
     * Creado por: Eliam Rodríguez Pérez
     * Creado: 2022-09-26
     *
     * @param Request $request
     * @param Response $response
     * @return void
     */
    public function update(Request $request, Response $response)
    {
        $session = new PhpSession();
        $userId = $session->get('userId');

        if (!$userId) {
            $response->setStatusCode(401)->json([
                "status" => false,
                "message" => "Not authorized"
            ]);
            return;
        }

        // TODO: Solo un usuario administrador puede actualizar
        $categoryId = $request->getRouteParams('categoryId');
        $name = $request->getBody('name');
        $description = $request->getBody('description');

        $category = new Category();
        $category
            ->setCategoryId($categoryId)
            ->setName($name)
            ->setDescription($description)
            ->setUserId($userId);

        $validator = new Validator($category);
        $feedback = $validator->validate();
        $status = $validator->getStatus();
        if (!$status) {
            $response->setStatusCode(400)->json([
                "status" => $status,
                "message" => $feedback
            ]);
            return;
        }

        $categoryRepository = new CategoryRepository();
        $result = $categoryRepository->update($category);
        if (!$result) {
            $response->setStatusCode(400)->json([
                "status" => $status,
                "message" => "No se pudo crear la categoría"
            ]);
            return;
        }

        $response->json([
            "status" => $result,
            "message" => [
                "id" => $categoryId,
                "name" => $name,
                "description" => $description
            ]
        ]);
    }

    /**
     * Elimina una categoría
     * Endpoint: DELETE api/v1/categories/:categoryId
     * Creado por: Eliam Rodríguez Pérez
     * Creado: 2022-09-26
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
        $requiredRule = new Required();
        $uuidRule = new _Uuid();

        if (!$requiredRule->isValid($categoryId) || !$uuidRule->isValid($categoryId)) {
            $response->setStatusCode(400)->json([
                "status" => false,
                "data" => "Uuid invalido"
            ]);
            return;
        }

        $categoryRepository = new CategoryRepository();
        $result = $categoryRepository->delete($categoryId);

        $response->json([
            "status" => $result
        ]);
    }

    /**
     * Obtiene todas las categorías
     * Endpoint: GET api/v1/categories
     * Creado por: Eliam Rodríguez Pérez
     * Creado: 2022-09-26
     *
     * @param Request $request
     * @param Response $response
     * @return void
     */
    public function getCategories(Request $request, Response $response)
    {
        $categoryRepository = new CategoryRepository();
        $categories = $categoryRepository->getAll();
        $response->json($categories);
    }
}
