<?php

namespace CakeFactory\Controllers;

use Fibi\Http\Controller;
use Fibi\Http\Request;
use Fibi\Http\Response;

class OrderController extends Controller
{
    public function checkout(Request $request, Response $response)
    {
        $names = $request->getBody("names");
        $lastName = $request->getBody("last-name");
        $streetAddress = $request->getBody("street-address");
        $city = $request->getBody("city");
        $state = $request->getBody("state");
        $postalCode = $request->getBody("postal-code");
        $email = $request->getBody("email");
        $phone = $request->getBody("phone");
        $cardNumber = $request->getBody("card-number");
        $expYear = $request->getBody("exp-year");
        $expMonth = $request->getBody("exp-month");
        $cvv = $request->getBody("cvv");
    }

    public function getOrders(Request $request, Response $response)
    {
        
    }
}

?>