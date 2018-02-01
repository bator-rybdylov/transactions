<?php

namespace Core;

class Router
{
    private $routes;

    public function __construct()
    {
        $this->routes = include ROOT . '/config/routes.php';
    }

    public function start()
    {
        $request_uri = $_SERVER['REQUEST_URI'];

        // Remove GET parameters from URI
        $request_uri_cleared = $request_uri;
        $params_pos = strpos($request_uri, '?');
        if (false !== $params_pos) {
            $request_uri_cleared = substr($request_uri, 0, $params_pos);
        }

        // Find controller and action by cleared URI
        foreach ($this->routes as $route) {
            if ($route['path'] === $request_uri_cleared) {
                $controller_name = 'Controller\\' . $route['controller'] . 'Controller';
                $action_name = $route['action'] . 'Action';

                $controller = new $controller_name;

                if (method_exists($controller, $action_name)) {
                    $controller->$action_name();
                } else {
                    throw new \Exception('Page not found');
                }

                break;
            }
        }
    }
}