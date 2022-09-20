<?php

namespace CakeFactory\Controllers;

use Fibi\Http\Request;
use Fibi\Http\Response;

class ProductController
{
    public function create(Request $request, Response $response)
    {
        $name = $request->getBody("name");
        $description = $request->getBody("description");

        $images = $request->getFileArray("images");
        $videos = $request->getFileArray("videos");
    }

    public function getUserProducts(Request $request, Response $response)
    {
        
    }
}

?>