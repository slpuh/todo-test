<?php

namespace SendPulseTest\Components;

use PDO;

class Db
{
    
    public static function getConnection()
    {
        $paramsPath = __DIR__ . '/../../config/database.php';
        $params = include($paramsPath);
        

        $dsn = "mysql:host={$params['host']};dbname={$params['dbname']}";
        $db = new PDO($dsn, $params['user'], $params['password']);
        $db->exec("set names utf8");
        
        return $db;
    }

}
