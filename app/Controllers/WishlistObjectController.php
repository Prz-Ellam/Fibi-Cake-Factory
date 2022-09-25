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
        $productId = $request->getBody("product");
        $userId = $request->getBody("user");
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


        }

        // TODO: Text acepte null tambien
        $response->json($wishlists);
    }

    public function deleteObject(Request $request, Response $response)
    {
        //$wishlistObjectId;

        $wishlistObjectRepository = new WishlistObjectRepository();
        
    }
}

?>