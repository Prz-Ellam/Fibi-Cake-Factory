<?php

namespace CakeFactory\Repositories;

use CakeFactory\Models\Chat;
use Fibi\Database\DB;

class ChatRepository
{
    private const CREATE = "";
    private const CHECK_IF_EXISTS = "CALL sp_check_chat_exists(:userId1, :userId2)";
    private const FIND_OR_CREATE = "CALL sp_find_or_create_chat(:chatId, :userId1, :userId2)";

    public function create(Chat $chat)
    {
        
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
        ])[0] ?? (object)null;
    }

    public function checkIfExists(string $userId1, string $userId2)
    {
        return DB::executeReader(self::CHECK_IF_EXISTS, [
            "userId1" => $userId1,
            "userId2" => $userId2
        ]); 
    }
}

?>