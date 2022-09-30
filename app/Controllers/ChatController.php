<?php

namespace CakeFactory\Controllers;

use CakeFactory\Repositories\ChatRepository;
use Fibi\Http\Controller;
use Fibi\Http\Request;
use Fibi\Http\Response;
use Fibi\Validation\Rules\Required;
use Fibi\Validation\Rules\Uuid;
use Ramsey\Uuid\Nonstandard\Uuid as NonstandardUuid;

class ChatController extends Controller
{
    public function create(Request $request, Response $response)
    {
        $request->getBody("message");
    }

    public function getChatMessages(Request $request, Response $response)
    {
        
    }

    public function findOrCreateChat(Request $request, Response $response)
    {
        $chatId = NonstandardUuid::uuid4()->toString();
        $userId1 = $request->getBody("userId1");
        $userId2 = $request->getBody("userId2");

        $required = new Required();
        $uuid = new Uuid();
        if (!$required->isValid($userId1) || !$required->isValid($userId2) ||
            !$uuid->isValid($userId1) || !$uuid->isValid($userId2))
        {
            $response->json(["status" => false]);
            return;
        }

        $chatRepository = new ChatRepository();
        $status = $chatRepository->findOrCreate($chatId, $userId1, $userId2);

        $response->json($status);
    }

    public function checkIfExists(Request $request, Response $response)
    {
        $userId1 = $request->getBody("userId1");
        $userId2 = $request->getBody("userId2");

        $required = new Required();
        if (!$required->isValid($userId1) || !$required->isValid($userId2))
        {
            $response->json(["status" => false]);
            return;
        }

        $chatRepository = new ChatRepository();
        $status = $chatRepository->checkIfExists($userId1, $userId2);

        // TODO: Index peligroso si no existe
        $response->json($status[0] ?? (object)null);
    }
}

?>