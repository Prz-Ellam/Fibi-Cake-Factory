<?php

namespace CakeFactory\Controllers;

use CakeFactory\Repositories\ImageRepository;
use Fibi\Http\Controller;
use Fibi\Http\Request;
use Fibi\Http\Response;

class ImageController extends Controller
{
    public function get(Request $request, Response $response)
    {
        $imageId = $request->getRouteParams('imageId');

        $imageRepository = new ImageRepository();
        $result = $imageRepository->getImage($imageId);

        if (count($result) < 1)
        {
            $response->setStatusCode(404);
            $response->json(["response" => "error"]);
            return;
        }
        

        $response->setContentType($result[0]["type"]);
        $response->setHeader("Content-Disposition", 'inline; filename="' . $result[0]["name"] . '"');
        $response->setBody($result[0]["content"]);
    }
}

?>