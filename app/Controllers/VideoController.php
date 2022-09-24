<?php

namespace CakeFactory\Controllers;

use CakeFactory\Repositories\VideoRepository;
use DateTime;
use Fibi\Http\Controller;
use Fibi\Http\Request;
use Fibi\Http\Response;

class VideoController extends Controller
{
    public function getVideo(Request $request, Response $response)
    {
        $videoId = $request->getRouteParams('videoId');

        $videoRepository = new VideoRepository();
        $result = $videoRepository->getVideo($videoId);

        if (count($result) < 1)
        {
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

?>