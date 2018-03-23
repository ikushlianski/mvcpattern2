<?php
/**
 * Created by PhpStorm.
 * User: ASUS
 * Date: 23.03.2018
 * Time: 14:11
 */

namespace Core;

use PDO;
use App\Config;

abstract class Model
{
    protected static function getDB()
    {
        static $db = null;
        if ($db === null) {
//            $host = 'localhost';
//            $dbname = 'mvcudemy';
//            $username = 'root';
//            $password = '';
            try {
                // $db = new PDO("mysql:host={$host};dbname={$dbname};charset=utf8", $username, $password);
                $dsn = "mysql:host=".Config::DB_HOST.";dbname=".Config::DB_NAME.";charset=utf8";
                $db = new PDO($dsn, Config::DB_USER, Config::DB_PASSWORD);

                // Throw an Exception if error occurs
                $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                return $db;
            } catch (\PDOException $e) {
                echo $e->getMessage();
            }
        }
    }
}