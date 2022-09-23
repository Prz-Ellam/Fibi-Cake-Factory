<?php

namespace CakeFactory\Controllers;

use CakeFactory\Models\Image;
use CakeFactory\Models\Product;
use CakeFactory\Models\Video;
use CakeFactory\Repositories\ImageRepository;
use CakeFactory\Repositories\ProductRepository;
use CakeFactory\Repositories\VideoRepository;
use Fibi\Http\Request;
use Fibi\Http\Response;
use Fibi\Session\PhpSession;
use LDAP\Result;
use Ramsey\Uuid\Nonstandard\Uuid;

class ProductController
{
    public function create(Request $request, Response $response)
    {
        var_dump($request->getBody("categories"));
        die();

        $productId = Uuid::uuid4()->toString();
        $name = $request->getBody("name");
        $description = $request->getBody("description");
        $typeOfSell = $request->getBody("type-of-sell");
        $price = $request->getBody("price");
        $stock = $request->getBody("stock");

        $images = $request->getFileArray("images");
        $videos = $request->getFileArray("videos");

        // Validar que esto existe realmente en la BD
        $categories = $request->getBody("categories");

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

        foreach ($videos as $video)
        {
            $videoId = Uuid::uuid4()->toString();
            $videoName = $image["name"];
            $videoType = $image["type"];
            $videoSize = $image["size"];
            $videoContent = file_get_contents($image["tmp_name"]);

            $video = new Video();
            $video->setVideoId($videoId)
                ->setName($videoName)
                ->setType($videoType)
                ->setSize($videoSize)
                ->setContent($videoContent)
                ->setMultimediaEntityId(3);

            $videoRepository = new VideoRepository();
            $result = $videoRepository->create($video);
        }

        foreach ($categories as $category)
        {
            $productCategoryId = Uuid::uuid4()->toString();
        }

        $product = new Product();
        $product->setProductId($productId)
            ->setName($name)
            ->setDescription($description)
            ->setTypeOfSell($typeOfSell)
            ->setPrice($price)
            ->setStock($stock);

        $productRepository = new ProductRepository();
        $productRepository->create($product);

        $response->json(($images));
    }

    public function updateProduct(Request $request, Response $response)
    {
        $productId = $request->getRouteParams('productId');
        $name = $request->getBody('name');
        $description = $request->getBody("description");
        $typeOfSell = $request->getBody("type-of-sell");
        $price = $request->getBody("price");
        $stock = $request->getBody("stock");
    }

    public function deleteProduct(Request $request, Response $response)
    {
        $productId = $request->getRouteParams('productId');

        $productRepository = new ProductRepository();
        $productRepository->delete($productId);
    }

    public function getUserProducts(Request $request, Response $response)
    {
        $userId = (new PhpSession())->get('user_id');

        // TODO: Validar que coincida con la sesión

    }

    public function getRecentProducts(Request $request, Response $response)
    {
        
    }

    public function getPendingProducts(Request $request, Response $response)
    {

    }

    public function getUserPendingProducts(Request $request, Response $response)
    {

    }

    public function getDeniedProducts(Request $request, Response $response)
    {

    }

    public function getUserDeniedProducts(Request $request, Response $response)
    {

    }

    public function getApproveProducts(Request $request, Response $response)
    {

    }

    public function getUserApproveProducts(Request $request, Response $response)
    {
        
    }
}

?>