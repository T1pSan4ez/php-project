<?php

use App\RMVC\App as App;
use App\RMVC\Route\Route;

session_start();


require '../vendor/autoload.php';


require '../routes/web.php';


$requestType = $_SERVER['REQUEST_METHOD'];
$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

Route::dispatch($requestType, $requestUri);

//App::run();

