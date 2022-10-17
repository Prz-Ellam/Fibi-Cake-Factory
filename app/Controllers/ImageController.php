<?php

namespace CakeFactory\Controllers;

use CakeFactory\Repositories\ImageRepository;
use DateTime;
use Fibi\Http\Controller;
use Fibi\Http\Request;
use Fibi\Http\Response;

class ImageController extends Controller
{
    /**
     * Obtiene la imagen en el formato correcto
     *
     * @param Request $request
     * @param Response $response
     * @return void
     */
    public function get(Request $request, Response $response): void
    {
        $imageId = $request->getRouteParams('imageId');

        $imageRepository = new ImageRepository();
        $result = $imageRepository->getImage($imageId);

        if (count($result) < 1) {
            $response->setStatusCode(404);
            $response->json(["response" => "error"]);
            return;
        }

        $response->setHeader("X-Image-Id", $result[0]["id"]);
        $response->setHeader("Content-Length", $result[0]["size"]);
        $response->setContentType($result[0]["type"]);
        $response->setHeader("Content-Disposition", 'inline; filename="' . $result[0]["name"] . '"');
        $dt = new DateTime($result[0]["created_at"]);
        $response->setHeader("Last-Modified", $dt->format('D, d M Y H:i:s \C\S\T'));
        $response->setBody($result[0]["content"]);
    }
}
