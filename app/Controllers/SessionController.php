<?php

namespace CakeFactory\Controllers;

use Fibi\Http\Controller;
use Fibi\Http\Request;
use Fibi\Http\Response;

class SessionController extends Controller
{
    /**
     * Inicia una sesión
     *
     * @param Request $request
     * @param Response $response
     * @return void
     */
    public function login(Request $request, Response $response) : void
    {
        $username = $request->getBody("username");
        $password = $request->getBody("password");
    }

    /**
     * Elimina la sesión
     *
     * @param Request $request
     * @param Response $response
     * @return void
     */
    public function logout(Request $request, Response $response) : void
    {
        
    }
}
