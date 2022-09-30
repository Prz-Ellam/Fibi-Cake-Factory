<?php

namespace CakeFactory\Middlewares;

use CakeFactory\Helpers\UserRolesEnum;
use Closure;
use Fibi\Http\Request;
use Fibi\Http\Response;
use Fibi\Session\PhpSession;

class RoleMiddleware
{
    public function admin(Request $request, Response $response, Closure $next)
    {
        $session = new PhpSession();
        $role = $session->get("role");

        if ($role !== UserRolesEnum::SUPERADMIN || $role !== UserRolesEnum::ADMIN)
        {
            $response->setStatusCode(401)->json([
                "status" => "Unauthorized"
            ]);
            return;
        }

        $next($request, $response);
    }
}
