<?php

namespace CakeFactory\Controllers;

use CakeFactory\Repositories\ChatParticipantRepository;
use Fibi\Http\Request;
use Fibi\Http\Response;

class ChatParticipantController
{
    public function getOneByUserId(Request $request, Response $response) : void
    {
        $userId = $request->getBody("userId");
        $chatId = $request->getBody("chatId");

        if (!$userId || !$chatId)
        {
            $response->json(["No hay"]);
            return;
        }

        $chatParticipantRepository = new ChatParticipantRepository();
        $chatParticipant = $chatParticipantRepository->getOneByUserId($userId, $chatId);

        if (count((array)$chatParticipant) < 1)
        {
            $response->json((object)[]);
            return;
        }

        $response->json([
            "id" => $chatParticipant["id"]
        ]);
    }
}
