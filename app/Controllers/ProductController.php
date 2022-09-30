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
use Fibi\Http\Controller;
use Fibi\Http\Request;
use Fibi\Http\Response;
use Fibi\Session\PhpSession;
use Ramsey\Uuid\Nonstandard\Uuid;

class ProductController extends Controller
{
    /**
     * Crea un producto
     *
     * @param Request $request
     * @param Response $response
     * @return void
     */
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

        // TODO: Validar que esto existe realmente en la BD
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

    /**
     * Actualiza un producto
     *
     * @param Request $request
     * @param Response $response
     * @return void
     */
    public function update(Request $request, Response $response)
    {
        $productId = $request->getRouteParams('productId');
        $name = $request->getBody('name');
        $description = $request->getBody("description");
        $typeOfSell = $request->getBody("type-of-sell");
        $price = $request->getBody("price");
        $stock = $request->getBody("stock");

        $images = $request->getFileArray("images");
        $videos = $request->getFileArray("videos");

        // Validar que esto existe realmente en la BD
        $categories = $request->getBody("categories");

        $product = new Product();
        $product
            ->setProductId($productId)
            ->setName($name)
            ->setDescription($description)
            ->setTypeOfSell($typeOfSell)
            ->setPrice($price)
            ->setStock($stock);
    
        $productRepository = new ProductRepository();
        $result = $productRepository->update($product);
    
        $response->json([
            "status" => $result,
            "data" => [
                "id" => $productId,
                "name" => $name,
                "description" => $description,
                "typeOfSell" => $typeOfSell,
                "price" => $price,
                "stock" => $stock
            ]
        ]);
    }

    /**
     * Elimina un producto
     *
     * @param Request $request
     * @param Response $response
     * @return void
     */
    public function delete(Request $request, Response $response)
    {
        $productId = $request->getRouteParams('productId');

        $productRepository = new ProductRepository();
        $result = $productRepository->delete($productId);

        // TODO: Si result es falso es BAD Request

        $response->json(["status" => $result]);
    }

    /**
     * Undocumented function
     *
     * @param Request $request
     * @param Response $response
     * @return void
     */
    public function getUserProducts(Request $request, Response $response)
    {
        //$userId = (new PhpSession())->get('user_id');
        $userId = $request->getRouteParams("userId");

        // TODO: Validar que coincida con la sesión

        $productRepository = new ProductRepository();
        $result = $productRepository->getUserProducts($userId);

        foreach ($result as &$element)
        {
            $element["categories"] = json_decode($element["categories"], true);
            foreach ($element["categories"] as &$category)
            {
                $category = json_decode($category, true);
            }
            
            $element["images"] = explode(',', $element["images"]);
            $element["videos"] = explode(',', $element["videos"]);
        }

        $response->json($result);
    }

    /**
     * Undocumented function
     *
     * @param Request $request
     * @param Response $response
     * @return void
     */
    public function getProduct(Request $request, Response $response)
    {
        $productId = $request->getRouteParams("productId");

        $productRepository = new ProductRepository();
        $product = $productRepository->getProduct($productId);

        if ($product === [])
        {
            $response->json((object)null);
            return;
        }
        $product = $product[0];

        $product["categories"] = json_decode($product["categories"], true);
        
        foreach ($product["categories"] as &$category)
        {
            $category = json_decode($category, true);
        }
            
        $product["images"] = explode(',', $product["images"]);
        $product["videos"] = explode(',', $product["videos"]);

        $response->json($product);
    }

    /**
     * Undocumented function
     *
     * @param Request $request
     * @param Response $response
     * @return void
     */
    public function getProducts(Request $request, Response $response)
    {
        $userId = (new PhpSession())->get('user_id');
        $userId = "516a3887-06b1-4203-ad59-07dc13d1e0fe";
        // TODO: Validar que coincida con la sesión

        $productRepository = new ProductRepository();
        $products = $productRepository->getUserProducts($userId);

        foreach ($products as &$element)
        {
            $element["categories"] = json_decode($element["categories"], true);
            foreach ($element["categories"] as &$category)
            {
                $category = json_decode($category, true);
            }
            
            $element["images"] = explode(',', $element["images"]);
            $element["videos"] = explode(',', $element["videos"]);
        }

        $response->json($products);
    }

    public function getRecentProducts(Request $request, Response $response)
    {
        $productRepository = new ProductRepository();
        $result = $productRepository->getRecentProducts();

        foreach ($result as &$element)
        {
            $element["images"] = json_decode($element["images"]);
            $element["videos"] = json_decode($element["videos"]);
        }

        $response->json($result);
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

    public function approve(Request $request, Response $response)
    {
        $productId = $request->getBody("productId");

        // Validar sesión
        $session = new PhpSession();
        $role = $session->get('role');

        if ($role !== "Super Administrador" && $role !== "Administrador")
        {
            $response->json([
                "status" => "Unauthorized"
            ])->setStatusCode(401);
            return;
        }

        $productRepository = new ProductRepository();
        //$productRepository->approve($productId);

    }

    public function denied(Request $request, Response $response)
    {
        $productId = $request->getBody("productId");
    }
}

?>