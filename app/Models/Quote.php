<?php

namespace CakeFactory\Models;

class Quote
{
    private ?string $quoteId = null;
    private ?string $sellerId = null;
    private ?string $shopperId = null;
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

    public function getSellerId() : ?string
    {
        return $this->sellerId;
    }

    public function setSellerId(?string $sellerId) : self
    {
        $this->sellerId = $sellerId;
        return $this;
    }

    public function getShopperId() : ?string
    {
        return $this->shopperId;
    }

    public function setShopperId(?string $shopperId): self
    {
        $this->shopperId = $shopperId;
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
