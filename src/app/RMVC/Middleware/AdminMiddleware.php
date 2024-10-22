<?php

namespace App\RMVC\Middleware;

class AdminMiddleware implements MiddlewareInterface
{
    public static function handle()
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['admin_role'] != 1) {
            http_response_code(404);
            include __DIR__ . '/../../../resources/views/404/Error404.php';
            exit();
        }
    }

}