<?php

namespace App\RMVC\Middleware;

class AuthMiddleware implements MiddlewareInterface
{
    public static function handle()
    {
        if (!isset($_SESSION['user']) || !isset($_SESSION['user']['id'])) {
            header('Location: /login');
            exit();
        }
    }

}