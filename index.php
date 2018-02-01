<?php

ini_set('display_errors', 1);

define('ROOT', dirname(__FILE__));

session_start();

require ROOT . '/src/App.php';
$app = new App();
$app->init();