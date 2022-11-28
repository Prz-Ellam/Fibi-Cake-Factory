<?php

namespace CakeFactory\Controllers;

use CakeFactory\Models\WishlistObject;
use CakeFactory\Repositories\WishlistObjectRepository;
use CakeFactory\Repositories\WishlistRepository;
use Fibi\Http\Controller;
use Fibi\Http\Request;
use Fibi\Http\Response;
use Fibi\Session\PhpSession;
use Ramsey\Uuid\Nonstandard\Uuid;

class WishlistObjectController extends Controller
{
    /**
     * Agrega un producto a una lista de deseos
     * Creado por: Eliam Rodríguez Pérez
     * Creado: 2022-10-21
     *
     * @param Request $request
     * @param Response $response
     * @return void
     */
    public function create(Request $request, Response $response): void
    {
        // TODO: Vulnerable
        $productId = $request->getBody("product-id");
        $wishlists = $request->getBody("wishlists");

        foreach ($wishlists as $wishlistId)
        {
            $wishlistObjectId = Uuid::uuid4()->toString();

            $wishlistObject = new WishlistObject();
            $wishlistObject
                ->setWishlistObjectId($wishlistObjectId)
                ->setWishlistId($wishlistId)
                ->setProductId($productId);

            $wishlistObjectRepository = new WishlistObjectRepository();
            $result = $wishlistObjectRepository->create($wishlistObject);

            if (!$result)
            {
                $response->json([
                    "status" => false,
                    "message" => "No se pudo guardar un producto en la lista de deseos"
                ]);
                return;
            }
        }

        // TODO: Text acepte null tambien
        $response->json($wishlists);
    }

    /**
     * Elimina un producto de la lista de deseos
     * Creado por: Eliam Rodríguez Pérez
     * Creado: 2022-10-21
     *
     * @param Request $request
     * @param Response $response
     * @return void
     */
    public function delete(Request $request, Response $response): void
    {
        $session = new PhpSession();
        $userId = $session->get("userId");

        $wishlistObjectId = $request->getRouteParams("wishlistObjectId");
        if (!Uuid::isValid($wishlistObjectId)) {
            $response->setStatusCode(404)->json([
                "status" => false,
                "message" => "El identificador no es válido"
            ]);
            return;
        }

        $wishlistObjectRepository = new WishlistObjectRepository();
        $wishlistObjectUserId = $wishlistObjectRepository->getWishlistObjectUserId($wishlistObjectId);

        if ($userId !== $wishlistObjectUserId) {
            $response->setStatusCode(404)->json([
                "status" => false,
                "message" => "No se pudo encontrar el recurso"
            ]);
            return;
        }

        $result = $wishlistObjectRepository->delete($wishlistObjectId);
        
        $response->json($result);
    }

    /**
     * Obtiene todos los productos de una lista
     * Creado por: Eliam Rodríguez Pérez
     * Creado: 2022-10-21
     *
     * @param Request $request
     * @param Response $response
     * @return void
     */
    public function getWishlistObjects(Request $request, Response $response): void
    {
        $session = new PhpSession();
        $userId = $session->get("userId");

        $wishlistId = $request->getRouteParams('wishlistId');

        $wishlistRepository = new WishlistRepository();
        $wishlistUserId = $wishlistRepository->getWishlistUserId($wishlistId);
        $wishlist = $wishlistRepository->getWishlist($wishlistId);

        if ($userId !== $wishlistUserId && $wishlist["visible"] === 0) {
            $response->setStatusCode(404)->json([
                "status" => false,
                "message" => "No se pudo encontrar el recurso"
            ]);
            return;
        }

        $wishlistObjectRepository = new WishlistObjectRepository();
        $wishlistObjects = $wishlistObjectRepository->getWishlistObjects($wishlistId, $userId);

        foreach ($wishlistObjects as &$wishlistObject) {
            $wishlistObject["images"] = explode(',', $wishlistObject["images"]);
        }

        $response->json($wishlistObjects);
    }
}
