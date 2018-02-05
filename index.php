<?php

define('ROOT', dirname(__FILE__));

session_start();

require ROOT . '/src/App.php';
$app = new App();
$app->init();