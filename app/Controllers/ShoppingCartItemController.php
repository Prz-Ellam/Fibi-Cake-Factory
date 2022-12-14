<?php

namespace CakeFactory\Controllers;

use CakeFactory\Models\Quote;
use CakeFactory\Models\ShoppingCartItem;
use CakeFactory\Repositories\ProductRepository;
use CakeFactory\Repositories\QuoteRepository;
use CakeFactory\Repositories\ShoppingCartItemRepository;
use CakeFactory\Repositories\ShoppingCartRepository;
use Fibi\Http\Controller;
use Fibi\Http\Request;
use Fibi\Http\Response;
use Fibi\Session\PhpSession;
use Ramsey\Uuid\Nonstandard\Uuid;

class ShoppingCartItemController extends Controller
{
    public function addItem(Request $request, Response $response)
    {
        $shoppingCartItemId = Uuid::uuid4()->toString(); 
        $productId = $request->getBody("product-id");
        $quantity = $request->getBody("quantity");

        $userId = (new PhpSession())->get('userId');

        $productRepository = new ProductRepository();
        $product = $productRepository->getProduct($productId, $userId)[0];
        if (!$product) {
            $response->json([
                "status" => false,
                "message" => "El producto solicitado no existe"
            ])->setStatusCode(400);
            return;
        }

        if ($product["stock"] < $quantity) {
            $response->json([
                "status" => false,
                "message" => "No hay suficiente cantidad de stock"
            ])->setStatusCode(400);
            return;
        }

        $quoteRepository = new QuoteRepository();
        $quote = $quoteRepository->getByUserProduct($userId, $productId);
        $isInQuote = ($quote !== []);
        
        if ($product["is_quotable"] ) {
            if (!$isInQuote) {
                // Crear una cotizacion 
                $quote = new Quote();
                $quote
                    ->setQuoteId(Uuid::uuid4()->toString())
                    ->setUserId($userId)
                    ->setProductId($productId);

                $quoteRepository = new QuoteRepository();
                $quoteRepository->create($quote);

                $response->json([
                    "status" => true,
                    "message" => "Se ha solicitado una cotizaci??n del producto"
                ]);
                return;
            }
            else if ($quote["price"] === null) {
                $response->json([
                    "status" => true,
                    "message" => "Ya se ha solicitado una cotizaci??n del producto"
                ]);
                return;
            }
        }

        $shoppingCartRepository = new ShoppingCartRepository();
        $shoppingCartId = $shoppingCartRepository->getUserCart($userId);

        $shoppingCartItem = new ShoppingCartItem();
        $shoppingCartItem
            ->setShoppingCartItemId($shoppingCartItemId)
            ->setShoppingCartId($shoppingCartId)
            ->setProductId($productId)
            ->setQuantity($quantity);

        $shoppingCartItemRepository = new ShoppingCartItemRepository();
        $result = $shoppingCartItemRepository->addShoppingCartItem($shoppingCartItem);

        $response->json([
            "status" => true,
            "message" => "Su producto ha sido a??adido al carrito"
        ]);
    }

    public function addItemQuantity(Request $request, Response $response)
    {
        $quantity = $request->getBody("quantity");
    }

    public function update(Request $request, Response $response): void
    {
        $userId = (new PhpSession())->get('userId');
        
        $shoppingCartItemId = $request->getRouteParams("shoppingCartItemId");
        $quantity = $request->getBody("quantity");

        if ($quantity < 1) {
            $response->json(["error"])->setStatusCode(400);
            return;
        }

        $shoppingCartItemRepository = new ShoppingCartItemRepository();

        $productId = $shoppingCartItemRepository->getProductId($shoppingCartItemId);
        $productRepository = new ProductRepository();
        $product = $productRepository->getProduct($productId, $userId)[0];
        if (!$product) {
            $response->json([
                "status" => false,
                "message" => "El producto solicitado no existe"
            ])->setStatusCode(400);
            return;
        }

        $itemQuantity = $shoppingCartItemRepository->getQuantity($shoppingCartItemId);
        if ($product["stock"] < $quantity - $itemQuantity) {
            $response->json([
                "status" => false,
                "message" => "No hay suficiente cantidad de stock"
            ])->setStatusCode(400);
            return;
        }
        

        $shoppingCartItem = new ShoppingCartItem();
        $shoppingCartItem
            ->setShoppingCartItemId($shoppingCartItemId)
            ->setQuantity($quantity - $itemQuantity);

        

        $result = $shoppingCartItemRepository->update($shoppingCartItem);

        $response->json([$result]);
        
    }

    public function removeItem(Request $request, Response $response)
    {
        $shoppingCartItemId = $request->getRouteParams("shoppingCartItemId");

        $shoppingCartItemRepository = new ShoppingCartItemRepository();
        $result = $shoppingCartItemRepository->removeShoppingCartItem($shoppingCartItemId);

        $response->text($result);
    }

    public function getShoppingCartItems(Request $request, Response $response)
    {
        $userId = (new PhpSession())->get('userId');

        $shoppingCartRepository = new ShoppingCartRepository();
        $shoppingCartId = $shoppingCartRepository->getUserCart($userId);

        $shoppingCartItemRepository = new ShoppingCartItemRepository();
        $result = $shoppingCartItemRepository->getShoppingCartItems($shoppingCartId);

        $response->json($result);
    }
}
