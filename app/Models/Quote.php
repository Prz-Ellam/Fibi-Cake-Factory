<?php

namespace CakeFactory\Models;

class Quote
{
    private ?string $quoteId = null;
    private ?string $userId = null;
    private ?string $productId = null;
    private ?float $price = null;

    public function getQuoteId() : ?string
    {
        return $this->quoteId;
    }

    public function setQuoteId(?string $quoteId) : self
    {
        $this->quoteId = $quoteId;
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

    public function getProductId() : ?string
    {
        return $this->productId;
    }

    public function setProductId(?string $productId): self
    {
        $this->productId = $productId;
        return $this;
    }

    public function getPrice() : ?float
    {
        return $this->price;
    }

    public function setPrice(?float $price): self
    {
        $this->price = $price;
        return $this;
    }

}
