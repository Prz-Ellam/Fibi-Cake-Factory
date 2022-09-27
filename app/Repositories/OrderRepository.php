<?php

namespace CakeFactory\Repositories;

use CakeFactory\Models\Order;
use Fibi\Database\DB;
use Fibi\Database\MainConnection;

class OrderRepository
{
    private const CREATE = "CALL sp_create_order(:orderId, :userId, :phone, :address, :city, :state, :postalCode)";
    private const GET_ALL_BY_USER = "";

    public function create(Order $order) : bool
    {
        $result = DB::executeNonQuery(self::CREATE, [
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