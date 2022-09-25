<?php

namespace CakeFactory\Controllers;

use Fibi\Http\Controller;
use Fibi\Http\Request;
use Fibi\Http\Response;

class ShoppingCartItemController extends Controller
{
    public function addItem(Request $request, Response $response)
    {
        $productId = $request->getBody("product");
        $quantity = $request->getBody("quantity");
    }

    public function addItemQuantity(Request $request, Response $response)
    {
        $quantity = $request->getBody("quantity");
    }

    public function removeItem(Request $request, Response $response)
    {
        $productId = $request->getBody("product");
    }
}

?>