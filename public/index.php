<?php

// ini_set('display_errors',1);
// error_reporting(E_ALL);

session_start();

define('VIEW', dirname(__DIR__) . '/views');
define('APP', dirname(__DIR__) . '/app');
define('LAYOUT', 'todo');


require __DIR__.'/../vendor/autoload.php';

$router = new \SendPulseTest\Components\Router();
$router->run();
