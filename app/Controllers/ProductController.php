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

    public function getUserProducts(Request $request, Response $response)
    {
        
    }
}

?>