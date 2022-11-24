<?php

namespace CakeFactory\Controllers;

use CakeFactory\Models\Image;
use CakeFactory\Models\Product;
use CakeFactory\Models\ProductCategory;
use CakeFactory\Models\Video;
use CakeFactory\Repositories\CategoryRepository;
use CakeFactory\Repositories\ImageRepository;
use CakeFactory\Repositories\ProductCategoryRepository;
use CakeFactory\Repositories\ProductRepository;
use CakeFactory\Repositories\VideoRepository;
use Fibi\Database\DB;
use Fibi\Http\Controller;
use Fibi\Http\Request;
use Fibi\Http\Response;
use Fibi\Session\PhpSession;
use Fibi\Validation\Rules\Required;
use Fibi\Validation\Rules\Uuid as RulesUuid;
use Fibi\Validation\Validator;
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
    public function create(Request $request, Response $response): void
    {
        $session = new PhpSession();
        $userId = $session->get("userId");

        $productId = Uuid::uuid4()->toString();
        $name = $request->getBody("name");
        $description = $request->getBody("description");
        $typeOfSell = $request->getBody("type-of-sell");
        $price = $request->getBody("price");
        $stock = $request->getBody("stock");
        $images = $request->getFiles("images");
        $video = $request->getFiles("video");

        // TODO: Validar que esto existe realmente en la BD
        $categories = $request->getBody("categories") ?? [];
        
        //DB::beginTransaction();

        $product = new Product();
        $product
            ->setProductId($productId)
            ->setName($name)
            ->setDescription($description)
            ->setTypeOfSell($typeOfSell)
            ->setPrice($price)
            ->setStock($stock)
            ->setUserId($userId);

        $validator = new Validator($product);
        $feedback = $validator->validate();
        $status = $validator->getStatus();
        if (!$status) {
            $response->json([
                "response" => $status,
                "message" => $feedback
            ])->setStatusCode(400);
            return;
        }

        $productRepository = new ProductRepository();
        $result = $productRepository->create($product);
        /*
        if (!$result) {
            $response->setStatusCode(400)->json([
                "status" => false,
                "message" => "No se pudo crear el producto"
            ]);
            return;
        }
        */

        $imagesId = [];
        if (count($images) < 1) {
            $response->json([
                "status" => false,
                "message" => "No hay imagenes"
            ]);
            return;
        }

        foreach ($images as $image) {
            $imageId = Uuid::uuid4()->toString();
            $imageName = $image->getName();
            $imageType = $image->getType();
            $imageSize = $image->getSize();
            $imageContent = $image->getContent();

            $image = new Image();
            $image
                ->setImageId($imageId)
                ->setName($imageName)
                ->setType($imageType)
                ->setSize($imageSize)
                ->setContent($imageContent)
                ->setMultimediaEntityId($productId)
                ->setMultimediaEntityType('products');

            $validator = new Validator($image);
            $feedback = $validator->validate();
            $status = $validator->getStatus();
            if (!$status) {
                $response->json([
                    "response" => $status,
                    "message" => $feedback
                ])->setStatusCode(400);
                return;
            }

            $imageRepository = new ImageRepository();
            $result = $imageRepository->create($image);
            if (!$result) {
                $response->setStatusCode(400)->json([
                    "response" => false,
                    "message" => "No se pudo crear una imagen"
                ]);
                return;
            }

            $imagesId[] = $imageId;
        }
        


        $videoId = Uuid::uuid4()->toString();
        $videoName = $video->getName();
        $videoType = $video->getType();
        $videoSize = $video->getSize();
        $videoContent = $video->getContent();

        $video = new Video();
        $video
            ->setVideoId($videoId)
            ->setName($videoName)
            ->setType($videoType)
            ->setSize($videoSize)
            ->setContent($videoContent)
            ->setMultimediaEntityId($productId)
            ->setMultimediaEntityType('products');

        $validator = new Validator($video);
        $feedback = $validator->validate();
        $status = $validator->getStatus();
        if (!$status) {
            $response->setStatusCode(400)->json([
                "response" => $status,
                "message" => $feedback
            ]);
            return;
        }

        $videoRepository = new VideoRepository();
        $result = $videoRepository->create($video);
        if (!$result) {
            $response->json([
                "status" => false,
                "message" => "No se pudo crear un video"
            ])->setStatusCode(400);
            return;
        }

        if (count($categories) < 1) {
            $response->json([
                "status" => false,
                "message" => "No hay categorias"
            ]);
            return;
        }

        foreach ($categories as $categoryId) {
            // TODO: Validar que este category Id si existe realmente, porque viene desde el
            // DOM y cualquiera lo puede manipular

            $productCategoryId = Uuid::uuid4()->toString();

            $productCategory = new ProductCategory();
            $productCategory
                ->setProductCategoryId($productCategoryId)
                ->setProductId($productId)
                ->setCategoryId($categoryId);

            $validator = new Validator($productCategory);
            $feedback = $validator->validate();
            $status = $validator->getStatus();
            if (!$status) {
                $response->json([
                    "response" => $status,
                    "data" => $feedback
                ])->setStatusCode(400);
                return;
            }

            $productCategoryRepository = new ProductCategoryRepository();
            $result = $productCategoryRepository->create($productCategory);
            if (!$result) {
                $response->json(["response" => "No"])->setStatusCode(400);
                return;
            }
        }

        //DB::endTransaction();

        $response->json([
            "status" => $result,
            "message" => "El producto ha sido creada con éxito"
        ]);
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
        $session = new PhpSession();
        $userId = $session->get("userId");

        $productId = $request->getRouteParams("productId");

        if (!Uuid::isValid($productId)) {
            $response->setStatusCode(404)->json([
                "status" => false,
                "message" => "El identificador no es válido"
            ]);
            return;
        }

        $productRepository = new ProductRepository();
        $productUserId = $productRepository->getProductUserId($productId);

        if ($userId !== $productUserId) {
            $response->setStatusCode(404)->json([
                "status" => false,
                "message" => "No se pudo encontrar el recurso"
            ]);
            return;
        }

        $name = $request->getBody('name');
        $description = $request->getBody("description");
        $typeOfSell = $request->getBody("type-of-sell");
        $price = $request->getBody("price");
        $stock = $request->getBody("stock");
        $images = $request->getFiles("images");
        $video = $request->getFiles("video");

        // Validar que esto existe realmente en la BD
        $categories = $request->getBody("categories") ?? [];

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

        $imageRepository = new ImageRepository();
        $imageRepository->deleteMultimediaEntityImages($productId, 'products');
        $imagesId = [];
        foreach ($images as $image) {
            $imageId = Uuid::uuid4()->toString();
            $imageName = $image->getName();
            $imageType = $image->getType();
            $imageSize = $image->getSize();
            $imageContent = $image->getContent();

            $image = new Image();
            $image->setImageId($imageId)
                ->setName($imageName)
                ->setType($imageType)
                ->setSize($imageSize)
                ->setContent($imageContent)
                ->setMultimediaEntityId($productId)
                ->setMultimediaEntityType('products');

            $validator = new Validator($image);
            $feedback = $validator->validate();
            $status = $validator->getStatus();

            if (!$status) {
                $response->json([
                    "status" => $status,
                    "message" => $feedback
                ])->setStatusCode(400);
                return;
            }

            $imageRepository = new ImageRepository();
            $result = $imageRepository->create($image);
            if (!$result) {
                $response->json(["response" => "No"]);
                return;
            }

            $imagesId[] = $imageId;
        }

        $videoRepository = new VideoRepository();
        $videoRepository->deleteMultimediaEntityVideos($productId, 'products');

        $videoId = Uuid::uuid4()->toString();
        $videoName = $video->getName();
        $videoType = $video->getType();
        $videoSize = $video->getSize();
        $videoContent = $video->getContent();

        $video = new Video();
        $video
            ->setVideoId($videoId)
            ->setName($videoName)
            ->setType($videoType)
            ->setSize($videoSize)
            ->setContent($videoContent)
            ->setMultimediaEntityId($productId)
            ->setMultimediaEntityType('products');

        $videoRepository = new VideoRepository();
        $result = $videoRepository->create($video);
        if (!$result) {
            $response->json([
                "status" => false,
                "message" => "No se pudo crear un video"
            ])->setStatusCode(400);
            return;
        }

        $categoryRepository = new CategoryRepository();
        $categoryRepository->deleteCategoriesProduct($productId);
        foreach ($categories as $categoryId) {

            $productCategoryId = Uuid::uuid4()->toString();

            $productCategory = new ProductCategory();
            $productCategory
                ->setProductCategoryId($productCategoryId)
                ->setProductId($productId)
                ->setCategoryId($categoryId);

            $validator = new Validator($productCategory);
            $feedback = $validator->validate();
            $status = $validator->getStatus();
            if (!$status) {
                $response->json([
                    "response" => $status,
                    "data" => $feedback
                ])->setStatusCode(400);
                return;
            }

            $productCategoryRepository = new ProductCategoryRepository();
            $result = $productCategoryRepository->create($productCategory);
            if (!$result) {
                $response->json(["response" => "No"])->setStatusCode(400);
                return;
            }
        }

        $validator = new Validator($video);
        $feedback = $validator->validate();
        $status = $validator->getStatus();
        if (!$status) {
            $response->setStatusCode(400)->json([
                "response" => $status,
                "message" => $feedback
            ]);
            return;
        }

        $response->json([
            "status" => $result,
            "message" => "El producto fue actualizado exitosamente"
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
        $session = new PhpSession();
        $userId = $session->get("userId");

        $productId = $request->getRouteParams("productId");

        if (!Uuid::isValid($productId)) {
            $response->setStatusCode(404)->json([
                "status" => false,
                "message" => "El identificador no es válido"
            ]);
            return;
        }

        $productRepository = new ProductRepository();
        $productUserId = $productRepository->getProductUserId($productId);

        if ($userId !== $productUserId) {
            $response->setStatusCode(404)->json([
                "status" => false,
                "message" => "No se pudo encontrar el recurso"
            ]);
            return;
        }

        $imageRepository = new ImageRepository();
        $imageRepository->deleteMultimediaEntityImages($productId, 'products');

        $videoRepository = new VideoRepository();
        $videoRepository->deleteMultimediaEntityVideos($productId, 'products');

        $result = $productRepository->delete($productId);
        if (!$result) {
            $response->setStatusCode(400)->json([
                "status" => false,
                "message" => "No se pudo eliminar la lista de deseos"
            ]);
            return;
        }

        $response->json(["status" => $result]);
    }

    /**
     * Obtiene todos los productos de un usuario
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

        foreach ($result as &$element) {
            $element["categories"] = json_decode($element["categories"], true);
            foreach ($element["categories"] as &$category) {
                $category = json_decode($category, true);
            }

            $element["images"] = explode(',', $element["images"]);
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

        if ($product === []) {
            $response->json((object)null);
            return;
        }
        $product = $product[0];

        $product["categories"] = explode(',', $product["categories"]);
        $product["categories_name"] = explode(',', $product["categories_name"]);
        $product["images"] = explode(',', $product["images"]);
        //$product["videos"] = explode(',', $product["videos"]);

        $response->json($product);
    }

    /**
     * Obtiene varios productos
     *
     * @param Request $request
     * @param Response $response
     * @return void
     */
    public function getProducts(Request $request, Response $response)
    {
        $search = $request->getQuery("search") ?? "";
        $filter = $request->getQuery("filter") ?? "";
        $order = $request->getQuery("order") ?? "asc";
        $category = $request->getQuery("category") ?? null;
        if ($category === "") $category = null;

        $userId = (new PhpSession())->get('userId');
        // TODO: Validar que coincida con la sesión

        $productRepository = new ProductRepository();
        $products = [];
        switch ($filter) {
            case "sells":
                $products = $productRepository->getAllByShips($order, $search, $category);
                break;
            case "price":
                $products = $productRepository->getAllByPrice($order, $search, $category);
                break;
            case "rates":
                $products = $productRepository->getAllByRate($order, $search, $category);
                break;
            case "alpha":
                $products = $productRepository->getAllByAlpha($order, $search, $category);
                break;
            case "recents":
                $products = $productRepository->getAllByRecent($userId);
                break;
            case "favorites":
                $products = $productRepository->getAllByUserFavorites($userId);
                break;
            default:
                $products = $productRepository->getAllByShips($order, $search, $category);
        }

        foreach ($products as &$element) {

            $element["images"] = explode(',', $element["images"]);
            //$element["videos"] = explode(',', $element["videos"]);
        }

        $response->json($products);
    }

    public function getRecentProducts(Request $request, Response $response)
    {
        /*
        $productRepository = new ProductRepository();
        $result = $productRepository->getRecentProducts();

        foreach ($result as &$element) {
            $element["images"] = explode(",", $element["images"]);
            $element["videos"] = explode(",", $element["videos"]);
        }

        $response->json($result);
        */
    }

    public function getPendingProducts(Request $request, Response $response)
    {
        $productRepository = new ProductRepository();
        $result = $productRepository->findAllByPending();

        foreach ($result as &$element) {
            $element["images"] = explode(",", $element["images"]);
            $element["videos"] = explode(",", $element["videos"]);
        }

        $response->json($result);
    }

    public function getUserPendingProducts(Request $request, Response $response)
    {
        $userId = $request->getRouteParams("userId");

        $required = new Required();
        $uuid = new RulesUuid();

        if (!$required->isValid($userId) || !$uuid->isValid($userId)) {
            $response->json(["Esta mal"])->setStatusCode(400);
            return;
        }

        $productRepository = new ProductRepository();
        $result = $productRepository->getAllByUserPending($userId);

        foreach ($result as &$element) {
            $element["images"] = explode(",", $element["images"]);
            $element["videos"] = explode(",", $element["videos"]);
        }

        $response->json($result);
    }

    public function getDeniedProducts(Request $request, Response $response)
    {
    }

    public function getUserDeniedProducts(Request $request, Response $response)
    {
        $userId = $request->getRouteParams("userId");

        $required = new Required();
        $uuid = new RulesUuid();

        if (!$required->isValid($userId) || !$uuid->isValid($userId)) {
            $response->json(["Esta mal"])->setStatusCode(400);
            return;
        }

        $productRepository = new ProductRepository();
        $result = $productRepository->getAllByUserDenied($userId);

        foreach ($result as &$element) {
            $element["images"] = explode(",", $element["images"]);
            $element["videos"] = explode(",", $element["videos"]);
        }

        $response->json($result);
    }

    public function getApproveProducts(Request $request, Response $response)
    {
    }

    public function getUserApproveProducts(Request $request, Response $response)
    {
        //$session = new PhpSession();
        //$userId = $session->get("userid");
        $userId = $request->getRouteParams("userId");

        $required = new Required();
        $uuid = new RulesUuid();

        if (!$required->isValid($userId) || !$uuid->isValid($userId)) {
            $response->json(["Esta mal"])->setStatusCode(400);
            return;
        }

        $productRepository = new ProductRepository();
        $result = $productRepository->getAllByUserApprove($userId);

        foreach ($result as &$element) {
            $element["images"] = explode(",", $element["images"]);
            $element["videos"] = explode(",", $element["videos"]);
        }

        $response->json($result);
    }

    public function approve(Request $request, Response $response)
    {
        $productId = $request->getRouteParams("productId");

        $required = new Required();
        $uuid = new RulesUuid();

        if (!$required->isValid($productId) || !$required->isValid($productId)) {
            $response->json(["Esta mal"])->setStatusCode(400);
            return;
        }

        // Validar sesión
        $session = new PhpSession();
        $userId = $session->get("userId");
        $role = $session->get('role');

        if ($role !== "Super Administrador" && $role !== "Administrador") {
            $response->json([
                "status" => "Unauthorized"
            ])->setStatusCode(401);
            return;
        }

        $productRepository = new ProductRepository();
        $result = $productRepository->approve($productId, $userId);

        if (!$result) {
            $response->json(["response" => "No"])->setStatusCode(400);
            return;
        }

        $response->json([
            "status" => true
        ]);
    }

    public function denied(Request $request, Response $response)
    {
        $productId = $request->getRouteParams("productId");

        $required = new Required();
        $uuid = new RulesUuid();

        if (!$required->isValid($productId) || !$required->isValid($productId)) {
            $response->json(["Esta mal"])->setStatusCode(400);
            return;
        }

        // Validar sesión
        $session = new PhpSession();
        $role = $session->get('role');
        $userId = $session->get("userId");

        if ($role !== "Super Administrador" && $role !== "Administrador") {
            $response->json([
                "status" => "Unauthorized"
            ])->setStatusCode(401);
            return;
        }

        $productRepository = new ProductRepository();
        $result = $productRepository->denied($productId, $userId);

        if (!$result) {
            $response->json(["response" => "No"])->setStatusCode(400);
            return;
        }

        $response->json([
            "status" => true
        ]);
    }

    public function getAllByPrice(Request $request, Response $response)
    {
        $productRepository = new ProductRepository();
        $results = $productRepository->getAllByPrice("asc");
        $response->json($results);
    }

    public function getAllByShips(Request $request, Response $response)
    {
        $productRepository = new ProductRepository();
        $results = $productRepository->getAllByShips("asc");

        foreach ($results as &$element) {
            $element["images"] = explode(",", $element["images"]);
        }

        $response->json($results);
    }

    public function getAllByAlpha(Request $request, Response $response)
    {
        $productRepository = new ProductRepository();
        $results = $productRepository->getAllByAlpha("asc");
        $response->json($results);
    }

    public function getApprovedProdcuts(Request $request, Response $response)
    {
        $userId = $request->getRouteParams("userId");

        $productRepository = new ProductRepository();
        $results = $productRepository->getAllByApprovedBy($userId);

        foreach ($results as &$element) {
            $element["categories"] = json_decode($element["categories"], true);
            foreach ($element["categories"] as &$category) {
                $category = json_decode($category, true);
            }

            $element["images"] = explode(',', $element["images"]);
            $element["videos"] = explode(',', $element["videos"]);
        }

        $response->json($results);
    }
}
