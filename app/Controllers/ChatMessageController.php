<?php

namespace CakeFactory\Controllers;

use CakeFactory\Models\ChatMessage;
use CakeFactory\Repositories\ChatMessagesRepository;
use Fibi\Http\Request;
use Fibi\Http\Response;
use Ramsey\Uuid\Nonstandard\Uuid;

class ChatMessageController
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

        // TODO: Validar que siempre sea un UUID

        $chatMessage = new ChatMessage();
        $chatMessage
            ->setChatMessageId($chatMessageId)
            ->setChatParticipantId($chatParticipantId)
            ->setMessageContent($messageContent);

        $chatMessagesRepository = new ChatMessagesRepository();
        $result = $chatMessagesRepository->create($chatMessage);

        if ($result === false)
        {
            $response->setStatusCode(400)->json([
                "status" => $result
            ]);
        }

        $response->json($chatMessage->toObject());
    }

    /**
     * Undocumented function
     *
     * @param Request $request
     * @param Response $response
     * @return void
     */
    public function getAllByChat(Request $request, Response $response) : void
    {
        // "c332f2ed-3edf-11ed-8be6-6018950ce9af"
        $chatId = $request->getRouteParams("chatId");

        $chatMessagesRepository = new ChatMessagesRepository();
        $chatMessages = $chatMessagesRepository->getAllByChat($chatId);

        $response->json($chatMessages);
    }
}