<?php

namespace CakeFactory\Models;

use Fibi\Model\Model;
use Fibi\Validation\Rules\MaxLength;
use Fibi\Validation\Rules\Required;
use Fibi\Validation\Rules\Uuid;

class Comment implements Model
{
    /**
     * Undocumented variable
     *
     * @var string|null
     */
    #[Required]
    #[Uuid]
    private ?string $commentId;

    /**
     * Undocumented variable
     *
     * @var string|null
     */
    #[Required]
    #[MaxLength(255)]
    private ?string $message;

    /**
     * Undocumented variable
     *
     * @var string|null
     */
    #[Required]
    #[Uuid]
    private ?string $productId;

    /**
     * Undocumented variable
     *
     * @var string|null
     */
    #[Required]
    #[Uuid]
    private ?string $userId;

    public function getCommentId() : ?string
    {
        return $this->commentId;
    }

    public function setCommentId(?string $commentId) : self
    {
        $this->commentId = $commentId;
        return $this;
    }

    public function getMessage() : ?string
    {
        return $this->message;
    }

    public function setMessage(?string $message) : self
    {
        $this->message = $message;
        return $this;
    }

    public function getProductId() : ?string
    {
        return $this->productId;
    }

    public function setProductId(?string $productId) : self
    {
        $this->productId = $productId;
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

?>