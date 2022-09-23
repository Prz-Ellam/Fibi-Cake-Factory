<?php

namespace CakeFactory\Controllers;

use CakeFactory\Repositories\VideoRepository;
use Fibi\Http\Controller;
use Fibi\Http\Request;
use Fibi\Http\Response;

class VideoController extends Controller
{
    public function getVideo(Request $request, Response $response)
    {
        $videoId = $request->getRouteParams('videoId');

        $videoRepository = new VideoRepository();
        $videoRepository->getVideo($videoId);
    }
}

?>