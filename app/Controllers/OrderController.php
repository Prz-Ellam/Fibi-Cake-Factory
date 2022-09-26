<?php

namespace CakeFactory\Controllers;

use CakeFactory\Models\Order;
use CakeFactory\Models\Shopping;
use CakeFactory\Models\ShoppingCart;
use CakeFactory\Repositories\OrderRepository;
use CakeFactory\Repositories\ShoppingCartItemRepository;
use CakeFactory\Repositories\ShoppingCartRepository;
use CakeFactory\Repositories\ShoppingRepository;
use Fibi\Http\Controller;
use Fibi\Http\Request;
use Fibi\Http\Response;
use Fibi\Session\PhpSession;
use Ramsey\Uuid\Nonstandard\Uuid;

class OrderController extends Controller
{
    public function checkout(Request $request, Response $response)
    {
        $orderId = Uuid::uuid4()->toString();
        $userId = (new PhpSession())->get('user_id');

        $names = $request->getBody("names");
        $lastName = $request->getBody("last-name");
        $address = $request->getBody("street-address");
        $city = $request->getBody("city");
        $state = $request->getBody("state");
        $postalCode = $request->getBody("postal-code");
        $email = $request->getBody("email");
        $phone = $request->getBody("phone");
        $cardNumber = $request->getBody("card-number");
        $expYear = $request->getBody("exp-year");
        $expMonth = $request->getBody("exp-month");
        $cvv = $request->getBody("cvv");

        $order = new Order();
        $order
            ->setOrderId($orderId)
            ->setUserId($userId)
            ->setPhone($phone)
            ->setAddress($address)
            ->setCity($city)
            ->setState($state)
            ->setPostalCode($postalCode);

        $orderRepository = new OrderRepository();
        $result = $orderRepository->create($order);

        if ($result === false)
        {
            $response->text("Error en crear orden");
            return;
        }

        $shoppingCartRepository = new ShoppingCartRepository();
        $shoppingCartId = $shoppingCartRepository->getUserCart($userId);
        $shoppingCartItemRepository = new ShoppingCartItemRepository();
        $shoppingCartItems = $shoppingCartItemRepository->getShoppingCartItems($shoppingCartId);

        $shoppingRepository = new ShoppingRepository();
        foreach ($shoppingCartItems as $shoppingCartItem)
        {
            $shoppingId = Uuid::uuid4()->toString();
            $productId = $shoppingCartItem["product_id"];
            $quantity = $shoppingCartItem["quantity"];
            $amount = $quantity * $shoppingCartItem["price"];

            $shopping = new Shopping();
            $shopping
                ->setShoppingId($shoppingId)
                ->setOrderId($orderId)
                ->setProductId($productId)
                ->setQuantity($quantity)
                ->setAmount($amount);

            $result = $shoppingRepository->create($shopping);
            if ($result === false)
            {
                $response->text("Error en crear una compra");
                return;
            }
        }

        $result = $shoppingCartRepository->delete($shoppingCartId);
        if ($result === false)
        {
            $response->text("Error al eliminar el carrito");
            return;
        }

        $newShoppingCartId = Uuid::uuid4()->toString();
        $shoppingCart = new ShoppingCart();
        $shoppingCart
            ->setShoppingCartId($newShoppingCartId)
            ->setUserId($userId);

        $result = $shoppingCartRepository->create($shoppingCart);
        if ($result === false)
        {
            $response->text("Error al crear el nuevo carrito");
            return;
        }

        $response->json([ $result ]);
    }

    public function getOrders(Request $request, Response $response)
    {
        
    }
}

?>