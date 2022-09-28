<?php

namespace CakeFactory\Repositories;

use CakeFactory\Models\ChatMessage;
use Fibi\Database\DB;

class ChatMessagesRepository
{
    private const CREATE = "CALL sp_create_chat_message(:chatMessageId, :chatParticipantId, :messageContent)";
    private const UPDATE = "";
    private const DELETE = "";
    private const GET_ALL_BY_CHAT = "CALL sp_get_messages_from_chat(:chatId)";

    public function create(ChatMessage $chatMessage) : bool
    {
        $result = DB::executeNonQuery(self::CREATE, [
            "chatMessageId" => $chatMessage->getChatMessageId(),
            "chatParticipantId" => $chatMessage->getChatParticipantId(),
            "messageContent" => $chatMessage->getMessageContent()
        ]);

        return $result > 0;
    }

    public function update(ChatMessage $chatMessage)
    {

    }

    public function delete(string $chatMessageId)
    {

    }

    public function getAllByChat(string $chatId)
    {
        $result = DB::executeReader(self::GET_ALL_BY_CHAT, [
            "chatId" => $chatId
        ]);
        return $result;
    }
}

?>