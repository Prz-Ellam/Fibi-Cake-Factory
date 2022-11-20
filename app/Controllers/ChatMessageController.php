<?php

namespace CakeFactory\Controllers;

use CakeFactory\Models\ChatMessage;
use CakeFactory\Repositories\ChatMessagesRepository;
use Fibi\Http\Controller;
use Fibi\Http\Request;
use Fibi\Http\Response;
use Fibi\Validation\Rules\Required;
use Fibi\Validation\Rules\Uuid as RulesUuid;
use Fibi\Validation\Validator;
use Ramsey\Uuid\Nonstandard\Uuid;

class ChatMessageController extends Controller
{
    /**
     * Undocumented function
     *
     * @param Request $request
     * @param Response $response
     * @return void
     */
    public function create(Request $request, Response $response) : void
    {
        $chatMessageId = Uuid::uuid4()->toString();
        $chatParticipantId = $request->getBody("chatParticipantId");
        $messageContent = $request->getBody("messageContent");

        $chatMessage = new ChatMessage();
        $chatMessage
            ->setChatMessageId($chatMessageId)
            ->setChatParticipantId($chatParticipantId)
            ->setMessageContent($messageContent);

        $validator = new Validator($chatMessage);
        $feedback = $validator->validate();
        $status = $validator->getStatus();

        if (!$status) {
            $response->setStatusCode(400)->json([
                "status" => $status,
                "data" => $feedback
            ]);
            return;
        }

        $chatMessagesRepository = new ChatMessagesRepository();
        $result = $chatMessagesRepository->create($chatMessage);

        if (!$result)
        {
            $response->setStatusCode(400)->json([
                "status" => $result
            ]);
        }

        $response->json($chatMessage->toObject());
    }

    /**
     * Obtener todos los mensajes de un chat
     *
     * @param Request $request
     * @param Response $response
     * @return void
     */
    public function getAllByChat(Request $request, Response $response) : void
    {
        // "c332f2ed-3edf-11ed-8be6-6018950ce9af"
        $chatId = $request->getRouteParams("chatId");

        $required = new Required();
        $uuid = new RulesUuid();
        if (!$required->isValid($chatId) || !$uuid->isValid($chatId))
        {
            $response->setStatusCode(400)->json([
                "status" => false
            ]);
            return;
        }

        $chatMessagesRepository = new ChatMessagesRepository();
        $chatMessages = $chatMessagesRepository->getAllByChat($chatId);

        $response->json($chatMessages);
    }
}
