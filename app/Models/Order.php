<?php

namespace CakeFactory\Models;

use Fibi\Model\Model;

class Order extends Model
{
    private ?string $orderId;
    private ?string $phone;
    private ?string $street;
    private ?string $city;
    private ?string $state;
    private ?string $postalCode;
    private ?string $creditCardNumber;
    private ?int $creditCardYearExp;
    private ?int $creditCardMonthExp;
    private ?string $creditCardCVV;
}

?>