<?php

namespace CakeFactory\Controllers;

use CakeFactory\Repositories\ShoppingCartRepository;
use Fibi\Http\Controller;
use Fibi\Http\Request;
use Fibi\Http\Response;
use Fibi\Session\PhpSession;

class ShoppingCartController extends Controller
{
    public function getUserCart(Request $request, Response $response)
    {
        $session = new PhpSession();
        $userId = $session->get('userId');

        $shoppingCartRepository = new ShoppingCartRepository();
        $shoppingCartId = $shoppingCartRepository->getUserCart($userId);

        $response->json([$shoppingCartId]);
    }
}

?>