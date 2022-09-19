<?php

namespace Fibi\Middlewares;

use Closure;
use Fibi\Http\Request;
use Fibi\Http\Response;

interface Middleware
{
    public function handle(Request $request, Response $response, Closure $next);
}

?>