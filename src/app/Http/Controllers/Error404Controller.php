<?php

namespace App\Http\Controllers;

use App\RMVC\Database\DB;
use App\RMVC\Route\Route;

class Error404Controller extends Controller
{
    public function notFound()
    {
        http_response_code(404);
        include __DIR__ . '/../../../resources/views/404/Error404.php';
        exit();
    }
}
