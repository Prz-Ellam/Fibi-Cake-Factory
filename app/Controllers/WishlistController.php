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
        // TODO: Validar que exista una sección activa

        $wishlistId = Uuid::uuid4()->toString();
        $name = $request->getBody("name");
        $description = $request->getBody("description");
        $visibility = $request->getBody("visibility");
        $images = $request->getFileArray("images");
        $userId = $request->getBody("user-id");
        if (is_null($userId))
            $userId = (new PhpSession())->get('user_id');

        // TODO: Las imagenes de listas borradas no deben poder ser accedidas
        $imagesId = [];
        foreach ($images as $image)
        {
            $imageId = Uuid::uuid4()->toString();

            $ext = explode('.', $image["name"])[1];

            //$JWT_SECRET = "3bb515fea33c5a653a5bbdcd20d958c8b7e49a91db0c74e91a04a0faab4f5c3a";
            //$jwt = JWT::encode([$imageId], $JWT_SECRET, "HS256");
            
            $imageName = "$imageId.$ext";
            //$imageName = $image["name"];
            $imageType = $image["type"];
            $imageSize = $image["size"];
            $imageContent = file_get_contents($image["tmp_name"]);

            $image = new Image();
            $image->setImageId($imageId)
                ->setName($imageName)
                ->setType($imageType)
                ->setSize($imageSize)
                ->setContent($imageContent)
                ->setMultimediaEntityId($wishlistId)
                ->setMultimediaEntityType('wishlists');

            $imageRepository = new ImageRepository();
            $result = $imageRepository->create($image);

            if ($result === false)
            {
                $response->json(["response" => "No"]);
            }
            $imagesId[] = $imageId;
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
            $response->json(["status" => $result]);
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
        $wishlistId = $request->getRouteParams("wishlistId");

        $name = $request->getBody("name");
        $description = $request->getBody("description");
        $visibility = $request->getBody("visibility");
        $images = $request->getFileArray("images");
        $userId = $request->getBody("user-id");
        if (is_null($userId))
            $userId = (new PhpSession())->get('user_id');

        // TODO: El tema de las imagenes
        $imageRepository = new ImageRepository();
        $imageRepository->deleteMultimediaEntityImages($wishlistId, 'wishlists');
        $imagesId = [];
        foreach ($images as $image)
        {
            $imageId = Uuid::uuid4()->toString();
            $imageName = $image["name"];
            $imageType = $image["type"];
            $imageSize = $image["size"];
            $imageContent = file_get_contents($image["tmp_name"]);

            $image = new Image();
            $image->setImageId($imageId)
                ->setName($imageName)
                ->setType($imageType)
                ->setSize($imageSize)
                ->setContent($imageContent)
                ->setMultimediaEntityId($wishlistId)
                ->setMultimediaEntityType('wishlists');

            $imageRepository = new ImageRepository();
            $result = $imageRepository->create($image);

            if ($result === false)
            {
                $response->json(["response" => "No"]);
                return;
            }

            $imagesId[] = $imageId;
        }

        $wishlist = new Wishlist();
        $wishlist->setWishlistId($wishlistId)
            ->setName($name)
            ->setDescription($description)
            ->setVisibility($visibility)
            ->setUserId($userId);

        $wishlistRepository = new WishlistRepository();
        $result = $wishlistRepository->update($wishlist);

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

        // TODO: Si result es falso es BAD Request

        $response->json(["status" => $result]);
    }

    public function getWishlist(Request $request, Response $response)
    {
        $wishlistId = $request->getRouteParams("wishlistId");
        $wishlistRepository = new WishlistRepository();
        $result = $wishlistRepository->getWishlist($wishlistId)[0];

        $result["images"] = json_decode($result["images"]);

        $response->json($result);
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
        $count = $request->getQuery("count") ?? 12;
        $page = $request->getQuery("page") ?? 1;

        $offset = floor($count * ($page - 1));

        $userId = $request->getRouteParams("userId");

        // TODO: Validar que coincida con la sesión

        $wishlistRepository = new WishlistRepository();
        $result = $wishlistRepository->getUserWishlists($userId, $count, $offset);

        if (is_null($result))
        {
            $response->setStatusCode(404)->json(["status" => "Not found"]);
            return;
        }

        foreach ($result as &$element)
        {
            $element["images"] = json_decode($element["images"]);
        }

        $response->json($result);
    }
}

?>