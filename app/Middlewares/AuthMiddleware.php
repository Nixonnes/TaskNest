<?php

namespace App\Middlewares;

use Core\Request;
use Core\Response;

class AuthMiddleware
{
    public function handle(Request $request, callable $next)
    {
        if(!isset($_SESSION['user_id'])) {
            header("Location:" . '/login');
        }

        return $next($request);
    }
}