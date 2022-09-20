<?php

namespace CakeFactory\Controllers;

use CakeFactory\Models\Image;
use CakeFactory\Models\Wishlist;
use CakeFactory\Repositories\ImageRepository;
use CakeFactory\Repositories\WishlistRepository;
use Fibi\Http\Controller;
use Fibi\Http\Request;
use Fibi\Http\Response;
use Fibi\Session\PhpSession;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Ramsey\Uuid\Nonstandard\Uuid;

class WishlistController extends Controller
{
    /**
     * Crea una lista de deseos
     *
     * @param Request $request
     * @param Response $response
     * @return void
     */
    public function create(Request $request, Response $response)
    {
        $wishlistId = Uuid::uuid4()->toString();
        $name = $request->getBody("name");
        $description = $request->getBody("description");
        $visibility = $request->getBody("visibility");
        $images = $request->getFileArray("images");
        $userId = (new PhpSession())->get('user_id');

        foreach ($images as $image)
        {
            $imageId = Uuid::uuid4()->toString();
            $imageName = $image["name"];
            $imageType = $image["type"];
            $imageSize = $image["size"];
            $imageContent = file_get_contents($image["tmp_name"]);

            // 3 - Multimedia type de listas de deseos
            $image = new Image();
            $image->setImageId($imageId)
                ->setName($imageName)
                ->setType($imageType)
                ->setSize($imageSize)
                ->setContent($imageContent)
                ->setMultimediaEntityId(3);

            $imageRepository = new ImageRepository();
            $result = $imageRepository->create($image);

            if ($result === false)
            {
                $response->json(["response" => "No"]);
            }

        }

        $wishlist = new Wishlist();
        $wishlist->setWishlistId($wishlistId)
            ->setName($name)
            ->setDescription($description)
            ->setVisibility($visibility)
            ->setUserId($userId);

        $wishlistRepository = new WishlistRepository();
        $result = $wishlistRepository->create($wishlist);

        if ($result === false)
        {
            $response->json(["response" => "No"]);
        }


        $response->json(["response" => "Si"]);
        //$response->json($request->getBody());






        /*
        $clientToken = $request->getHeaders('Authorization');

        try {
        $result = JWT::decode(
            $clientToken, 
            new Key("3bb515fea33c5a653a5bbdcd20d958c8b7e49a91db0c74e91a04a0faab4f5c3a", "HS256"));

            $session = new PhpSession();
            $sessionToken = $session->get('token');

            if ($sessionToken != $clientToken)
            {
                $response->text("No valid");
                return;
            }
        }
        catch (Exception $ex)
        {
            $response->text("No valid");
            return;
        }

        if (is_null($clientToken))
        {
            $response->text("null");
            return;
        }

        $response->text($clientToken);
        */
    }

    /**
     * Actualizar una lista de deseos existente
     *
     * @param Request $request
     * @param Response $response
     * @return void
     */
    public function update(Request $request, Response $response)
    {
        $name = $request->getBody("name");
        $description = $request->getBody("description");
        $visibility = $request->getBody("visibility");

        var_dump($request->getFile());
        die;

        $wishlist = new Wishlist();

        $wishlistRepository = new WishlistRepository();
        $result = $wishlistRepository->update($wishlist);

        $response->json(["status" => $result]);
    }

    /**
     * Eliminar una lista de deseos
     *
     * @param Request $request
     * @param Response $response
     * @return void
     */
    public function delete(Request $request, Response $response)
    {
        $wishlistId = $request->getRouteParams("wishlistId");

        $wishlistRepository = new WishlistRepository();
        $result = $wishlistRepository->delete($wishlistId);

        $response->json(["status" => $result]);
    }

    /**
     * Obtener las listas de deseos de un usuario
     *
     * @param Request $request
     * @param Response $response
     * @return void
     */
    public function getUserWishlists(Request $request, Response $response)
    {
        $userId = $request->getRouteParams("userId");
        $wishlistRepository = new WishlistRepository();
        $result = $wishlistRepository->getUserWishlists($userId);

        $response->json($result);
    }
}

?>