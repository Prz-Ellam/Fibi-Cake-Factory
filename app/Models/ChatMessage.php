<?php

namespace CakeFactory\Models;

use Fibi\Model\Model;
use Fibi\Validation\Rules\Required;

class ChatMessage implements Model
{
    /**
     * Undocumented variable
     *
     * @var string|null
     */
    #[Required]
    private ?string $chatMessageId;

    /**
     * Undocumented variable
     *
     * @var string|null
     */
    private ?string $chatParticipantId;

    /**
     * Undocumented variable
     *
     * @var string|null
     */
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

    public function toObject() : array
    {
        $members = get_object_vars($this);
        return json_decode(json_encode($members), true);
    }

    public static function getProperties() : array
    {
        return array_keys(get_class_vars(self::class));
    }
}

?>