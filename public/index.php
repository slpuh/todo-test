<?php

ini_set('display_errors',1);
error_reporting(E_ALL);

session_start();

require __DIR__.'/../vendor/autoload.php';

$router = new \SendPulseTest\Components\Router();
$router->run();
