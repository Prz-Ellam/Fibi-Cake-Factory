<?php

namespace CakeFactory\Models;

use Fibi\Model\Model;

class Rate implements Model
{
    private ?string $rateId;

    private ?int $rate;

    private ?string $productId;

    private ?string $userId;

    public function getRateId() : ?string
    {
        return $this->rateId;
    }

    public function setRateId(?string $rateId) : self
    {
        $this->rateId = $rateId;
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

?>