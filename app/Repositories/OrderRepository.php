<?php

namespace CakeFactory\Repositories;

use CakeFactory\Models\Order;
use Fibi\Database\MainConnection;

class OrderRepository
{
    private MainConnection $connection;
    private const CREATE_ORDER = "CALL sp_create_order(:orderId, :userId, :phone, :address, :city, :state, :postalCode)";

    public function __construct() {
        $this->connection = new MainConnection();
    }

    public function create(Order $order) : bool
    {
        $result = $this->connection->executeNonQuery(self::CREATE_ORDER, [
            "orderId"       => $order->getOrderId(),
            "userId"        => $order->getUserId(),
            "phone"         => $order->getPhone(),
            "address"       => $order->getAddress(),
            "city"          => $order->getCity(),
            "state"         => $order->getState(),
            "postalCode"    => $order->getPostalCode()
        ]);

        return $result > 0;
    }
}

?>