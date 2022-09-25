<?php

namespace CakeFactory\Models;

use Fibi\Model\Model;

class ChatMessage extends Model
{
    private ?string $chatMessageId;
    private ?string $chatParticipantId;
    private ?string $messageContent;

    public function getChatMessageId() : ?string
    {
        return $this->chatMessageId;
    }

    public function setChatMessageId(?string $chatMessageId) : self
    {
        $this->chatMessageId = $chatMessageId;
        return $this;
    }

    public function getChatParticipantId() : ?string
    {
        return $this->chatParticipantId;
    }

    public function setChatParticipantId(?string $chatParticipantId) : self
    {
        $this->chatParticipantId = $chatParticipantId;
        return $this;
    }

    public function getMessageContent() : ?string
    {
        return $this->messageContent;
    }

    public function setMessageContent(?string $messageContent) : self
    {
        $this->messageContent = $messageContent;
        return $this;
    }
}

?>