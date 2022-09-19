<?php

namespace CakeFactory\Controllers;

use Exception;
use Fibi\Http\Controller;
use Fibi\Http\Request;
use Fibi\Http\Response;
use Fibi\Session\PhpSession;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class WishlistController extends Controller
{
    /**
     * Crea una lista de deseos
     *
     * @param Request $request
     * @param Response $response
     * @return void
     */
    public function create(Request $request, Response $response)
    {
        // $request->getBody();

        var_dump($request->getFile());
        die;


        //$response->json($request->getBody());






        /*
        $clientToken = $request->getHeaders('Authorization');

        try {
        $result = JWT::decode(
            $clientToken, 
            new Key("3bb515fea33c5a653a5bbdcd20d958c8b7e49a91db0c74e91a04a0faab4f5c3a", "HS256"));

            $session = new PhpSession();
            $sessionToken = $session->get('token');

            if ($sessionToken != $clientToken)
            {
                $response->text("No valid");
                return;
            }
        }
        catch (Exception $ex)
        {
            $response->text("No valid");
            return;
        }

        if (is_null($clientToken))
        {
            $response->text("null");
            return;
        }

        $response->text($clientToken);
        */
    }

    public function update(Request $request, Response $response)
    {

    }

    public function delete(Request $request, Response $response)
    {

    }

    public function getAll(Request $request, Response $response)
    {

    }
}

?>