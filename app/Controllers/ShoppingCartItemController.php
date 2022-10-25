<?php

namespace CakeFactory\Controllers;

use CakeFactory\Models\ShoppingCartItem;
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

        $response->json([$result]);
    }

    public function addItemQuantity(Request $request, Response $response)
    {
        $quantity = $request->getBody("quantity");
    }

    public function update(Request $request, Response $response): void
    {
        $shoppingCartItemId = $request->getRouteParams("shoppingCartItemId");
        $quantity = $request->getBody("quantity");

        $shoppingCartItem = new ShoppingCartItem();
        $shoppingCartItem
            ->setShoppingCartItemId($shoppingCartItemId)
            ->setQuantity($quantity);

        $shoppingCartItemRepository = new ShoppingCartItemRepository();
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

?>