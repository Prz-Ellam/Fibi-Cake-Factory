<?php

namespace CakeFactory\Controllers;

use Fibi\Http\Controller;
use Fibi\Http\Request;
use Fibi\Http\Response;

class WishlistObjectController extends Controller
{
    public function addObject(Request $request, Response $response)
    {
        $productId = $request->getBody("product");
        $userId = $request->getBody("user");
    }

    public function deleteObject(Request $request, Response $response)
    {
        
    }
}

?>