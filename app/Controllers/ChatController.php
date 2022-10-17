<?php

namespace CakeFactory\Controllers;

use CakeFactory\Models\Chat;
use CakeFactory\Models\ChatParticipant;
use CakeFactory\Repositories\ChatParticipantRepository;
use CakeFactory\Repositories\ChatRepository;
use Fibi\Database\DB;
use Fibi\Http\Controller;
use Fibi\Http\Request;
use Fibi\Http\Response;
use Fibi\Validation\Rules\Required;
use Fibi\Validation\Rules;
use Fibi\Validation\Validator;
use Ramsey\Uuid\Nonstandard\Uuid;

class ChatController extends Controller
{
    public function create(Request $request, Response $response)
    {
        $chatRepository = new ChatRepository();

        $chatId = Uuid::uuid4()->toString();
        $chat = new Chat();
        $chat->setChatId($chatId);

        $validator = new Validator($chat);
        $feedback = $validator->validate();
        $status = $validator->getStatus();

        if (!$status) {
            $response->json([
                "status" => false,
                "message" => $feedback
            ])->setStatusCode(400);
            return;
        }

        $result = $chatRepository->create($chat);
        if (!$result) {
            $response->json([
                "status" => false,
                "message" => "No se pudo crear el chat"
            ])->setStatusCode(400);
            return;
        }
    }

    public function getChatMessages(Request $request, Response $response)
    {
    }

    /**
     * Undocumented function
     *
     * @param Request $request
     * @param Response $response
     * @return void
     */
    public function findOrCreateChat(Request $request, Response $response)
    {
        $chatId = Uuid::uuid4()->toString();
        $userId1 = $request->getBody("userId1");
        $userId2 = $request->getBody("userId2");

        // Validar que estos dos usuarios

        $required = new Required();
        $uuid = new Rules\Uuid();
        if (
            !$required->isValid($userId1) || !$required->isValid($userId2) ||
            !$uuid->isValid($userId1) || !$uuid->isValid($userId2)
        ) {
            $response->json([
                "status" => false
            ]);
            return;
        }

        $chatRepository = new ChatRepository();
        $status = $chatRepository->findOneByUsers($userId1, $userId2);
        if (count((array)$status) > 0) {
            $response->json([
                "id" => $status["id"]
            ]);
            return;
        }

        DB::beginTransaction();

        $chatId = Uuid::uuid4()->toString();
        $chat = new Chat();
        $chat->setChatId($chatId);

        $validator = new Validator($chat);
        $feedback = $validator->validate();
        $status = $validator->getStatus();

        if (!$status) {
            $response->json([
                "status" => false,
                "message" => $feedback
            ])->setStatusCode(400);
            return;
        }

        $result = $chatRepository->create($chat);
        if (!$result) {
            $response->json([
                "status" => false,
                "message" => "No se pudo crear el chat"
            ])->setStatusCode(400);
            return;
        }

        $usersId = [$userId1, $userId2];
        for ($i = 0; $i < 2; $i++) {
            $chatParticipantRepository = new ChatParticipantRepository();
            $chatParticipantId = Uuid::uuid4()->toString();

            $chatParticipant = new ChatParticipant();
            $chatParticipant
                ->setChatParticipantId($chatParticipantId)
                ->setChatId($chatId)
                ->setUserId($usersId[$i]);

            $validator = new Validator($chatParticipant);
            $feedback = $validator->validate();
            $status = $validator->getStatus();

            if (!$status) {
                $response->json([
                    "status" => false,
                    "message" => $feedback
                ])->setStatusCode(400);
                return;
            }

            $result = $chatParticipantRepository->create($chatParticipant);
            if (!$result) {
                $response->json([
                    "status" => false,
                    "message" => "No se pudo crear un participante"
                ])->setStatusCode(400);
                return;
            }
        }

        DB::endTransaction();

        $response->json([
            "id" => $chatId
        ]);
    }

    public function checkIfExists(Request $request, Response $response)
    {
        $userId1 = $request->getBody("userId1");
        $userId2 = $request->getBody("userId2");

        $required = new Required();
        if (!$required->isValid($userId1) || !$required->isValid($userId2)) {
            $response->json(["status" => false]);
            return;
        }

        $chatRepository = new ChatRepository();
        $status = $chatRepository->checkIfExists($userId1, $userId2);

        // TODO: Index peligroso si no existe
        $response->json($status[0] ?? (object)null);
    }
}
