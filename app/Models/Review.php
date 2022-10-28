<?php

namespace CakeFactory\Models;

use Fibi\Model\Model;
use Fibi\Validation\Rules\Max;
use Fibi\Validation\Rules\MaxLength;
use Fibi\Validation\Rules\Required;
use Fibi\Validation\Rules\Uuid;

class Review implements Model
{
    /**
     * Undocumented variable
     *
     * @var string|null
     */
    #[Required]
    #[Uuid]
    private ?string $reviewId = null;

    /**
     * Undocumented variable
     *
     * @var string|null
     */
    #[Required]
    #[MaxLength(255)]
    private ?string $message = null;

    /**
     * Undocumented variable
     *
     * @var integer|null
     */
    #[Required]
    #[Max(5)]
    private ?int $rate = null;

    /**
     * Undocumented variable
     *
     * @var string|null
     */
    #[Required]
    #[Uuid]
    private ?string $productId = null;

    /**
     * Undocumented variable
     *
     * @var string|null
     */
    #[Required]
    #[Uuid]
    private ?string $userId = null;

    public function getReviewId() : ?string
    {
        return $this->reviewId;
    }

    public function setReviewId(?string $reviewId) : self
    {
        $this->reviewId = $reviewId;
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

    public function getRate() : ?int
    {
        return $this->rate;
    }

    public function setRate(?int $rate) : self
    {
        $this->rate = $rate;
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
