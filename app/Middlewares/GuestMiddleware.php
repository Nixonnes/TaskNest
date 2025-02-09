<?php

namespace App\Middlewares;

use Core\Request;

class GuestMiddleware
{
    public function handle(Request $request, callable $next)
    {
        if(isset($_SESSION['user_id'])) {
            header("Location:" . '/tasks');
        }

        return $next($request);
    }
}