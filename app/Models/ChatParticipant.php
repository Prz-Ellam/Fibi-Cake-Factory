<?php

namespace CakeFactory\Models;

use Fibi\Model\Model;

class ChatParticipant extends Model
{
    private ?string $chatParticipantId;
    private ?string $chatId;
    private ?string $userId;

    public function getChatParticipantId() : ?string
    {
        return $this->chatParticipantId;
    }

    public function setChatParticipantId(?string $chatParticipantId) : self
    {
        $this->chatParticipantId = $chatParticipantId;
        return $this;
    }

    public function getChatId() : ?string
    {
        return $this->chatId;
    }

    public function setChatId(?string $chatId) : self
    {
        $this->chatId = $chatId;
        return $this;
    }

    public function getUserId() : ?string
    {
        return $this->userId;
    }

    public function setUserId(?string $userId) : self
    {
        $this->userId = $userId;
        return $this;
    }
}

?>