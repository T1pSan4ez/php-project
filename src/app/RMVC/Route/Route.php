<?php

namespace App\RMVC\Route;

use App\Http\Controllers\Error404Controller;

class Route
{
    private static array $routesGet = [];
    private static array $routesPost = [];

    public static function getRoutesGet(): array
    {
        return self::$routesGet;
    }

    public static function getRoutesPost(): array
    {
        return self::$routesPost;
    }

    public static function get(string $route, array $controller): RouteConfiguration
    {
        $routeConfiguration = new RouteConfiguration($route, $controller[0], $controller[1]);
        self::$routesGet[] = $routeConfiguration;
        return $routeConfiguration;
    }

    public static function post(string $route, array $controller): RouteConfiguration
    {
        $routeConfiguration = new RouteConfiguration($route, $controller[0], $controller[1]);
        self::$routesPost[] = $routeConfiguration;
        return $routeConfiguration;
    }

    public static function redirect($url)
    {
        header('Location: ' . $url);
        exit();
    }

    public static function dispatch($requestType, $requestUri)
    {
        $routes = $requestType === 'POST' ? self::$routesPost : self::$routesGet;

        foreach ($routes as $routeConfiguration) {
            if (preg_match("#^" . preg_replace('/\{[^\}]+\}/', '([0-9]+)', $routeConfiguration->route) . "$#", $requestUri, $matches)) {
                array_shift($matches);
                if ($middleware = $routeConfiguration->getMiddleware()) {
                    $middlewareClass = "App\\RMVC\\Middleware\\{$middleware}";
                    if (class_exists($middlewareClass) && method_exists($middlewareClass, 'handle')) {
                        $middlewareInstance = new $middlewareClass();
                        $middlewareInstance->handle();
                    }
                }

                $controller = new $routeConfiguration->controller();
                $action = $routeConfiguration->action;
                $controller->$action(...$matches);
                return;
            }
        }

        self::handle404();
    }

    public static function handle404()
    {
        $errorController = new Error404Controller();
        $errorController->notFound();
    }
}
