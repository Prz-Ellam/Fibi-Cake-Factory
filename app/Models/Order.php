<?php

namespace CakeFactory\Models;

use Fibi\Model\Model;

class Order extends Model
{
    private ?string $orderId;
    private ?string $userId;
    private ?string $phone;
    private ?string $address;
    private ?string $city;
    private ?string $state;
    private ?string $postalCode;

    public function getOrderId() : ?string
    {
        return $this->orderId;
    }

    public function setOrderId(?string $orderId) : self
    {
        $this->orderId = $orderId;
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

    public function getPhone() : ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone) : self
    {
        $this->phone = $phone;
        return $this;
    }

    public function getAddress() : ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address) : self
    {
        $this->address = $address;
        return $this;
    }

    public function getCity() : ?string
    {
        return $this->city;
    }

    public function setCity(?string $city) : self
    {
        $this->city = $city;
        return $this;
    }

    public function getState() : ?string
    {
        return $this->state;
    }

    public function setState(?string $state) : self
    {
        $this->state = $state;
        return $this;
    }

    public function getPostalCode() : ?string
    {
        return $this->postalCode;
    }

    public function setPostalCode(?string $postalCode) : self
    {
        $this->postalCode = $postalCode;
        return $this;
    }

    public function toObject() : array|null
    {
        $members = get_object_vars($this);
        return json_decode(json_encode($members), true);
    }


}

?>