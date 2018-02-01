<?php

use Core\Router;
use Core\DB;

class App
{
    public static $db;

    public function init()
    {
        spl_autoload_register(['static','loadClass']);

        self::$db = new DB();

        $router = new Router();
        try {
            $router->start();
        } catch (Exception $e) {
            echo $e->getMessage();
            die;
        }
    }

    public static function loadClass($className)
    {
        $className = str_replace('\\', '/', $className);
        require_once ROOT . '/src/' . $className . '.php';
    }
}