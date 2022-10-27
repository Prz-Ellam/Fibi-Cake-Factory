<?php

namespace CakeFactory\Controllers;

use CakeFactory\Models\WishlistObject;
use CakeFactory\Repositories\WishlistObjectRepository;
use Fibi\Http\Controller;
use Fibi\Http\Request;
use Fibi\Http\Response;
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
    public function addObject(Request $request, Response $response): void
    {
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
    public function deleteObject(Request $request, Response $response): void
    {
        $wishlistObjectId = $request->getRouteParams("wishlistObjectId");

        $wishlistObjectRepository = new WishlistObjectRepository();
        $result = $wishlistObjectRepository->delete($wishlistObjectId);
        
        $response->text($result);
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
        $wishlistId = $request->getRouteParams('wishlistId');
        $wishlistObjectRepository = new WishlistObjectRepository();
        $results = $wishlistObjectRepository->getWishlistObjects($wishlistId);

        foreach ($results as &$element) {
            $element["images"] = explode(',', $element["images"]);
        }

        $response->json($results);
    }
}
