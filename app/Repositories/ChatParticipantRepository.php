<?php

namespace CakeFactory\Repositories;

use CakeFactory\Models\ChatParticipant;
use Fibi\Database\DB;

class ChatParticipantRepository
{
    private const CREATE = "CALL sp_create_chat_participant(:chatParticipantId, :chatId, :userId)";
    private const GET_ONE_BY_USER_ID = "CALL sp_chat_participants_find_by_user(:chatId, :userId)";

    public function create(ChatParticipant $chatParticipant)
    {
        return DB::executeNonQuery(self::CREATE, [
            "chatParticipantId" => $chatParticipant->getChatParticipantId(),
            "chatId" => $chatParticipant->getChatId(),
            "userId" => $chatParticipant->getUserId()
        ]) > 0;
    }

    public function getOneByUserId(string $userId, string $chatId) : array|object
    {
        return DB::executeReader(self::GET_ONE_BY_USER_ID, [
            "chatId" => $chatId,
            "userId" => $userId
        ])[0] ?? (object)[];
    }
}
