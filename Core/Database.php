<?php
namespace Core;
use PDO;
use PDOException;
use const App\Config\DB_HOST;
use const App\Config\DB_NAME;
use const App\Config\DB_PASSWORD;
use const App\Config\DB_USERNAME;

require_once 'App\Config\config.php';
require_once 'autoload.php';

abstract class Database {
    //Function used to connect to the database using PDO
    public static function connectToDatabase(): ?PDO
    {
        static $connection = null;

        try {
            $connection = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USERNAME, DB_PASSWORD);
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            echo 'Connection Error: ' . $e->getMessage();
        }

        return $connection;
    }
}