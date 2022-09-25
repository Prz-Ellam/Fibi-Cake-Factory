<?php

namespace CakeFactory\Models;

use Fibi\Model\Model;

class Chat extends Model
{
    private ?string $chatId;

    public function getChatId() : ?string
    {
        return $this->chatId;
    }

    public function setChatId(?string $chatId) : self
    {
        $this->chatId = $chatId;
        return $this;
    }
}

?>