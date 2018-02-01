<?php

namespace Core;

class DB
{
    public $pdo;

    public function __construct()
    {
        $db_config = $this->getDBConfig();
        try {
            $this->pdo = new \PDO($db_config['dsn'], $db_config['user'], $db_config['pass'], null);
        } catch (\PDOException $e) {
            print "Error: " . $e->getMessage() . "<br/>";
            die();
        }
    }

    protected function getDBConfig()
    {
        $config = include ROOT . '/config/database.php';
        $result['dsn'] = $config['driver'] . ":host=" . $config['host'] . ";dbname=" . $config['dbname'];
        $result['user'] = $config['user'];
        $result['pass'] = $config['pass'];
        return $result;
    }
}