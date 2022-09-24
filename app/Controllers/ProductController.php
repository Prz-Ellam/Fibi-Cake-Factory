<?php

namespace CakeFactory\Controllers;

use CakeFactory\Models\Image;
use CakeFactory\Models\Product;
use CakeFactory\Models\ProductCategory;
use CakeFactory\Models\Video;
use CakeFactory\Repositories\ImageRepository;
use CakeFactory\Repositories\ProductCategoryRepository;
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

        $userId = $request->getBody("user-id");
        if (is_null($userId))
            $userId = (new PhpSession())->get('user_id');

        $imagesId = [];
        foreach ($images as $image)
        {
            $imageId = Uuid::uuid4()->toString();
            $ext = explode('.', $image["name"])[1];

            $imageName = "$imageId.$ext";
            //$imageName = $image["name"];
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
                ->setMultimediaEntityId($productId)
                ->setMultimediaEntityType('products');

            $imageRepository = new ImageRepository();
            $result = $imageRepository->create($image);

            if ($result === false)
            {
                $response->json(["response" => "No"]);
            }

            $imagesId[] = $imageId;
        }

        $videosId = [];
        foreach ($videos as $video)
        {
            $videoId = Uuid::uuid4()->toString();

            $ext = explode('.', $video["name"])[1];
            $videoName = "$videoId.$ext";
            $videoType = $video["type"];
            $videoSize = $video["size"];
            $videoContent = file_get_contents($video["tmp_name"]);

            $video = new Video();
            $video->setVideoId($videoId)
                ->setName($videoName)
                ->setType($videoType)
                ->setSize($videoSize)
                ->setContent($videoContent)
                ->setMultimediaEntityId($productId)
                ->setMultimediaEntityType('products');

            $videoRepository = new VideoRepository();
            $result = $videoRepository->create($video);

            $videosId[] = $videoId;
        }

        foreach ($categories as $categoryId)
        {
            // TODO: Validar que este category Id si existe realmente, porque viene desde el
            // DOM y cualquiera lo puede manipular

            $productCategoryId = Uuid::uuid4()->toString();

            $productCategory = new ProductCategory();
            $productCategory
                ->setProductCategoryId($productCategoryId)
                ->setProductId($productId)
                ->setCategoryId($categoryId);

            $productCategoryRepository = new ProductCategoryRepository();
            $result = $productCategoryRepository->create($productCategory); 
        }

        $product = new Product();
        $product->setProductId($productId)
            ->setName($name)
            ->setDescription($description)
            ->setTypeOfSell($typeOfSell)
            ->setPrice($price)
            ->setStock($stock)
            ->setUserId($userId);

        $productRepository = new ProductRepository();
        $result = $productRepository->create($product);

        $response->json([$result]);
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

    public function delete(Request $request, Response $response)
    {
        $productId = $request->getRouteParams('productId');

        $productRepository = new ProductRepository();
        $result = $productRepository->delete($productId);

        // TODO: Si result es falso es BAD Request

        $response->json(["status" => $result]);
    }

    public function getUserProducts(Request $request, Response $response)
    {
        $userId = (new PhpSession())->get('user_id');

        // TODO: Validar que coincida con la sesión

        $productRepository = new ProductRepository();
        $result = $productRepository->getUserProducts($userId);

        $response->json([
            "data" => $result
        ]);

    }

    public function getProduct(Request $request, Response $response)
    {
        $productId = $request->getRouteParams("productId");

        $productRepository = new ProductRepository();
        $result = $productRepository->getProduct($productId);

        if ($result === [])
        {
            $response->json((object)null);
            return;
        }

        $result[0]["images"] = json_decode($result[0]["images"]);
        $result[0]["videos"] = json_decode($result[0]["videos"]);

        $response->json($result[0]);
    }

    public function getProducts(Request $request, Response $response)
    {
        $userId = (new PhpSession())->get('user_id');
        $userId = "516a3887-06b1-4203-ad59-07dc13d1e0fe";
        // TODO: Validar que coincida con la sesión

        $productRepository = new ProductRepository();
        $result = $productRepository->getUserProducts($userId);

        foreach ($result as &$element)
        {
            $element["images"] = json_decode($element["images"]);
            $element["videos"] = json_decode($element["videos"]);
        }

        $response->json($result);
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