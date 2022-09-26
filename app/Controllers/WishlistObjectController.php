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
    public function addObject(Request $request, Response $response)
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

            if ($result === false)
            {
                $response->text("no");return;
            }
        }

        // TODO: Text acepte null tambien
        $response->json($wishlists);
    }

    public function deleteObject(Request $request, Response $response)
    {
        $wishlistObjectId = $request->getRouteParams("wishlistObjectId");

        $wishlistObjectRepository = new WishlistObjectRepository();
        $result = $wishlistObjectRepository->delete($wishlistObjectId);
        
        $response->text($result);
    }

    public function getWishlistObjects(Request $request, Response $response)
    {
        $wishlistId = $request->getRouteParams('wishlistId');

        $wishlistObjectRepository = new WishlistObjectRepository();
        $result = $wishlistObjectRepository->getWishlistObjects($wishlistId);
        $response->json($result);
    }
}

?>