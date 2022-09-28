<?php

namespace CakeFactory\Controllers;

use Fibi\Http\Controller;
use Fibi\Http\Request;
use Fibi\Http\Response;

class ChatController extends Controller
{
    public function create(Request $request, Response $response)
    {
        $request->getBody("message");
    }

    public function getChatMessages(Request $request, Response $response)
    {
        
    }
}

?>