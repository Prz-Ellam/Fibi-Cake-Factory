<?php

namespace CakeFactory\Repositories;

use CakeFactory\Models\Chat;
use Fibi\Database\DB;

class ChatRepository
{
    private const CREATE = "CALL sp_create_chat(:chatId)";
    private const CHECK_IF_EXISTS = "CALL sp_check_chat_exists(:userId1, :userId2)";
    private const FIND_OR_CREATE = "CALL sp_find_or_create_chat(:chatId, :userId1, :userId2)";
    private const FIND_ONE_BY_USERS = "CALL sp_chats_find_one_by_users(:userId1, :userId2)";

    public function create(Chat $chat) : bool
    {
        return DB::executeNonQuery(self::CREATE, [
            "chatId" => $chat->getChatId()
        ]) > 0;
    }

    /**
     * Busca el identificador del chat entre dos usuarios y si no lo encuentra crea un nuevo
     * registro
     *
     * @param string $userId1
     * @param string $userId2
     * @return array
     */
    public function findOrCreate(string $chatId, string $userId1, string $userId2) : array
    {
        return DB::executeReader(self::FIND_OR_CREATE, [
            "chatId"    => $chatId,
            "userId1"   => $userId1,
            "userId2"   => $userId2
        ])[0] ?? (object)[];
    }

    public function checkIfExists(string $userId1, string $userId2)
    {
        return DB::executeReader(self::CHECK_IF_EXISTS, [
            "userId1" => $userId1,
            "userId2" => $userId2
        ]); 
    }

    /**
     * Busca un chat que tenga dos usuarios solicitados
     *
     * @param string $userId1
     * @param string $userId2
     * @return array|object
     */
    public function findOneByUsers(string $userId1, string $userId2) : array|object
    {
        return DB::executeReader(self::FIND_ONE_BY_USERS, [
            "userId1" => $userId1,
            "userId2" => $userId2
        ])[0] ?? (object)[];
    }
}

?>