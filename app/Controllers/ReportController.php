<?php

namespace CakeFactory\Controllers;

use CakeFactory\Repositories\OrderRepository;
use Fibi\Http\Controller;
use Fibi\Http\Request;
use Fibi\Http\Response;
use Fibi\Session\PhpSession;

class ReportController extends Controller
{
    public function getOrderReport(Request $request, Response $response)
    {
        $from = $request->getQuery("from");
        $to = $request->getQuery("to");
        $categoryId = $request->getQuery("category");

        $session = new PhpSession();
        $userId = $session->get("user_id");

        $orderRepository = new OrderRepository();

        $results = $orderRepository->getOrderReport($userId, $categoryId, $from, $to);
        foreach ($results as &$result)
        {
            $result["categories"] = explode(',', $result["categories"]);
        }
    
        $response->json($results);
    }

    public function getSalesReport2(Request $request, Response $response)
    {
        $from = $request->getQuery("from");
        $to = $request->getQuery("to");
        $categoryId = $request->getQuery("category");

        $session = new PhpSession();
        $userId = $session->get("user_id");

        $orderRepository = new OrderRepository();

        $results = $orderRepository->getSalesReport2($userId, $categoryId, $from, $to);
        $response->json($results);
    }

    public function getSalesReport(Request $request, Response $response)
    {
        $from = $request->getQuery("from");
        $to = $request->getQuery("to");
        $categoryId = $request->getQuery("category");

        $session = new PhpSession();
        $userId = $session->get("user_id");

        $orderRepository = new OrderRepository();

        $results = $orderRepository->getSalesReport($userId, $categoryId, $from, $to);
        foreach ($results as &$result)
        {
            $result["categories"] = explode(',', $result["categories"]);
        }
    
        $response->json($results);
    }
}
