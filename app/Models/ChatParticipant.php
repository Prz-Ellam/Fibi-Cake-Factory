<?php

namespace CakeFactory\Models;

use Fibi\Model\Model;
use Fibi\Validation\Rules\Required;

class ChatParticipant implements Model
{
    /**
     * ID del participante del chat
     *
     * @var string|null
     */
    #[Required]
    private ?string $chatParticipantId = null;

    /**
     * ID del chat
     *
     * @var string|null
     */
    #[Required]
    private ?string $chatId = null;
    
    /**
     * ID del usuario
     *
     * @var string|null
     */
    #[Required]
    private ?string $userId = null;

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
