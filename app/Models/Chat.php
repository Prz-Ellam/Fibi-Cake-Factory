<?php

namespace CakeFactory\Models;

use Fibi\Model\Model;
use Fibi\Validation\Rules\Required;
use Fibi\Validation\Rules\Uuid;

class Chat implements Model
{
    /**
     * Undocumented variable
     *
     * @var string|null
     */
    #[Required]
    #[Uuid]
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