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

/*
        $output = fopen("php://output",'w') or die("Can't open php://output");
        fputcsv($output, array_keys($results[0]));
        foreach($results as $element) {
            fputcsv($output, $element);
        }
        fclose($output) or die("Can't close php://output");
        header('Content-Type: text/csv');
       header('Content-Disposition: attachment; filename="export.csv"');
       header('Pragma: no-cache');    
       header('Expires: 0');
       */

        foreach ($results as &$result)
        {
            $result["categories"] = explode(',', $result["categories"]);
        }
    
        $response->json($results);
    }
}
