<?php

namespace CakeFactory\Middlewares;

use Closure;
use Fibi\Http\Request;
use Fibi\Http\Response;
use Fibi\Session\PhpSession;

class AuthMiddleware
{
    public function action(Request $request, Response $response, Closure $next)
    {
        $session = new PhpSession();
        $role = $session->get("user_id");

        if (!$role)
        {
            $response->setStatusCode(404)->text("404 Not found");
            return;
        }

        $next($request, $response);
    }
}

?>