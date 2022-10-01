<?php

namespace CakeFactory\Repositories;

use CakeFactory\Models\Order;
use Fibi\Database\DB;

class OrderRepository
{
    private const CREATE = "CALL sp_create_order(:orderId, :userId, :phone, :address, :city, :state, :postalCode)";
    private const GET_ALL_BY_USER = "";
    private const FIND_ORDER_REPORT = "CALL sp_get_orders_report(:userId, :categoryId, :from, :to)";
    private const FIND_SALES_REPORT_2 = "CALL sp_get_sales_report_2(:userId, :categoryId, :from, :to)";
    private const FIND_SALES_REPORT = "CALL sp_get_sales_report(:userId, :categoryId, :from, :to)";

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

    public function getOrderReport(string $userId, ?string $categoryId, ?string $from, ?string $to) : array
    {
        return DB::executeReader(self::FIND_ORDER_REPORT, [
            "userId" => $userId,
            "categoryId" => $categoryId,
            "from" => $from,
            "to" => $to
        ]);
    }

    public function getSalesReport2(string $userId, ?string $categoryId, ?string $from, ?string $to) : array
    {
        return DB::executeReader(self::FIND_SALES_REPORT_2, [
            "userId" => $userId,
            "categoryId" => $categoryId,
            "from" => $from,
            "to" => $to
        ]);
    }

    public function getSalesReport(string $userId, ?string $categoryId, ?string $from, ?string $to) : array
    {
        return DB::executeReader(self::FIND_SALES_REPORT, [
            "userId" => $userId,
            "categoryId" => $categoryId,
            "from" => $from,
            "to" => $to
        ]);
    }
}
