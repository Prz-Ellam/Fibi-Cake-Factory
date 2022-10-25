<?php

namespace CakeFactory\Controllers;

use Fibi\Http\Controller;
use Fibi\Http\Request;
use Fibi\Http\Response;

use CakeFactory\Models\Wishlist;
use CakeFactory\Repositories\WishlistRepository;
use CakeFactory\Models\Image;
use CakeFactory\Repositories\ImageRepository;

use Fibi\Session\PhpSession;
use Fibi\Validation\Validator;
use Ramsey\Uuid\Nonstandard\Uuid;

/**
 * Controlador de las listas de deseos
 */
class WishlistController extends Controller
{
    /**
     * Crea una lista de deseos
     * Endpoint: POST /api/v1/wishlists
     * Creado por: Eliam Rodríguez Pérez
     * Creado: 2022-09-28
     *
     * @param Request $request
     * @param Response $response
     * @return void
     */
    public function create(Request $request, Response $response)
    {
        // TODO: Validar que exista una sección activa
        $session = new PhpSession();

        $wishlistId = Uuid::uuid4()->toString();
        $name = $request->getBody("name");
        $description = $request->getBody("description");
        $visible = $request->getBody("visible");
        $images = $request->getFiles("images");
        $userId = $session->get('userId');

        $wishlist = new Wishlist();
        $wishlist
            ->setWishlistId($wishlistId)
            ->setName($name)
            ->setDescription($description)
            ->setVisible($visible)
            ->setUserId($userId);

        $validator = new Validator($wishlist);
        $feedback = $validator->validate();
        $status = $validator->getStatus();

        if (!$status) {
            $response->json([
                "status" => $status,
                "message" => $feedback
            ])->setStatusCode(400);
            return;
        }

        $wishlistRepository = new WishlistRepository();
        $result = $wishlistRepository->create($wishlist);

        if (!$result) {
            $response->json([
                "status" => $result
            ])->setStatusCode(400);
            return;
        }

        // TODO: Las imagenes de listas borradas no deben poder ser accedidas
        $imagesId = [];
        foreach ($images as $image) {
            $imageId = Uuid::uuid4()->toString();
            $imageName = $image->getName();
            $imageType = $image->getType();
            $imageSize = $image->getSize();
            $imageContent = $image->getContent();

            $image = new Image();
            $image->setImageId($imageId)
                ->setName($imageName)
                ->setType($imageType)
                ->setSize($imageSize)
                ->setContent($imageContent)
                ->setMultimediaEntityId($wishlistId)
                ->setMultimediaEntityType('wishlists');

            $validator = new Validator($image);
            $feedback = $validator->validate();
            $status = $validator->getStatus();

            if (!$status) {
                $response->json([
                    "status" => $status,
                    "message" => $feedback
                ])->setStatusCode(400);
                return;
            }

            $imageRepository = new ImageRepository();
            $result = $imageRepository->create($image);

            if (!$result) {
                $response->json(["response" => "No"])->setStatusCode(400);
                return;
            }

            $imagesId[] = $imageId;
        }

        $response->json([
            "status" => $result,
            "message" => "La lista de deseos ha sido creada con éxito",
            "data" => [
                "id" => $wishlistId,
                "name" => $name,
                "images" => $imagesId,
                "visible" => $visible,
                "description" => $description
            ]
        ]);
    }

    /**
     * Actualizar una lista de deseos existente
     * Endpoint: POST /api/v1/wishlists/:wishlistId
     * Creado por: Eliam Rodríguez Pérez
     * Creado: 2022-10-21
     *
     * @param Request $request
     * @param Response $response
     * @return void
     */
    public function update(Request $request, Response $response): void
    {
        $session = new PhpSession();

        $wishlistId = $request->getRouteParams("wishlistId");
        $name = $request->getBody("name");
        $description = $request->getBody("description");
        $visibility = $request->getBody("visible");
        $images = $request->getFiles("images");
        $userId = $session->get('userId');

        $wishlist = new Wishlist();
        $wishlist
            ->setWishlistId($wishlistId)
            ->setName($name)
            ->setDescription($description)
            ->setVisible($visibility)
            ->setUserId($userId);

        $validator = new Validator($wishlist);
        $feedback = $validator->validate();
        $status = $validator->getStatus();
    
        if (!$status) {
            $response->json([
                "status" => $status,
                "message" => $feedback
            ])->setStatusCode(400);
            return;
        }
    
        $wishlistRepository = new WishlistRepository();
        $result = $wishlistRepository->update($wishlist);

        // $result - Edit

        // TODO: El tema de las imagenes
        $imageRepository = new ImageRepository();
        $imageRepository->deleteMultimediaEntityImages($wishlistId, 'wishlists');
        $imagesId = [];
        foreach ($images as $image) {
            $imageId = Uuid::uuid4()->toString();
            $imageName = $image->getName();
            $imageType = $image->getType();
            $imageSize = $image->getSize();
            $imageContent = $image->getContent();

            $image = new Image();
            $image->setImageId($imageId)
                ->setName($imageName)
                ->setType($imageType)
                ->setSize($imageSize)
                ->setContent($imageContent)
                ->setMultimediaEntityId($wishlistId)
                ->setMultimediaEntityType('wishlists');

            $validator = new Validator($image);
            $feedback = $validator->validate();
            $status = $validator->getStatus();

            if (!$status) {
                $response->json([
                    "status" => $status,
                    "message" => $feedback
                ])->setStatusCode(400);
                return;
            }

            $imageRepository = new ImageRepository();
            $result = $imageRepository->create($image);

            if (!$result) {
                $response->json(["response" => "No"]);
                return;
            }

            $imagesId[] = $imageId;
        }

        $response->json([
            "status" => $result,
            "data" => [
                "id" => $wishlistId,
                "name" => $name,
                "images" => $imagesId,
                "visibility" => $visibility,
                "description" => $description
            ]
        ]);
    }

    /**
     * Eliminar una lista de deseos
     * Endpoint: POST /api/v1/wishlists/:wishlistId
     * Creado por: Eliam Rodríguez Pérez
     * Creado: 2022-10-21
     *
     * @param Request $request
     * @param Response $response
     * @return void
     */
    public function delete(Request $request, Response $response): void
    {
        // TODO: Que no se pueda borrar los que no te pertenecen
        $wishlistId = $request->getRouteParams("wishlistId");

        $wishlistRepository = new WishlistRepository();
        $result = $wishlistRepository->delete($wishlistId);

        // TODO: Si result es falso es BAD Request

        $response->json(["status" => $result]);
    }

    /**
     * Obtiene una lista de deseos
     * Endpoint: GET /api/v1/wishlists/:wishlistId
     * Creado por: Eliam Rodríguez Pérez
     * Creado: 2022-10-20
     *
     * @param Request $request
     * @param Response $response
     * @return void
     */
    public function getWishlist(Request $request, Response $response): void
    {
        $wishlistId = $request->getRouteParams("wishlistId");
        $wishlistRepository = new WishlistRepository();
        $result = $wishlistRepository->getWishlist($wishlistId)[0];

        $result["images"] = json_decode($result["images"]);

        $response->json($result);
    }

    /**
     * Obtener las listas de deseos de un usuario
     * Endpoint: GET /api/v1/users/:userId/wishlists
     * Creado por: Eliam Rodríguez Pérez
     * Creado: 2022-10-20
     *
     * @param Request $request
     * @param Response $response
     * @return void
     */
    public function getUserWishlists(Request $request, Response $response): void
    {
        $session = new PhpSession();

        // TODO: que aqui salgan tanto las publicas como las normales
        $count = $request->getQuery("count") ?? 12;
        $page = $request->getQuery("page") ?? 1;
        $offset = floor($count * ($page - 1));

        $userId = $request->getRouteParams("userId");
        $userIdSession = $session->get("userId");

        // TODO: Validar que coincida con la sesión
        $wishlistRepository = new WishlistRepository();
        $result = ($userId === $userIdSession) ? 
            $wishlistRepository->getUserWishlists($userId, $count, $offset) :
            $wishlistRepository->getAllByUserPublic($userId, $count, $offset);

        if (!$result) {
            $response->setStatusCode(404)->json([
                "status" => false,
                "message" => "Not found"
            ]);
            return;
        }

        foreach ($result as &$element) {
            $element["images"] = json_decode($element["images"]);
        }

        $response->json($result);
    }

    public function getUserPublicWishlists(Request $request, Response $response): void
    {
        $count = $request->getQuery("count") ?? 12;
        $page = $request->getQuery("page") ?? 1;

        $offset = floor($count * ($page - 1));

        $userId = $request->getRouteParams("userId");

        // TODO: Validar que coincida con la sesión

        $wishlistRepository = new WishlistRepository();
        $result = $wishlistRepository->getAllByUserPublic($userId, $count, $offset);

        if (is_null($result)) {
            $response->setStatusCode(404)->json(["status" => "Not found"]);
            return;
        }

        foreach ($result as &$element) {
            $element["images"] = json_decode($element["images"]);
        }

        $response->json($result);
    }
}
