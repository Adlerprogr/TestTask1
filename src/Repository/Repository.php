<?php

namespace Repository;

use PDO;

class Repository
{
    protected static PDO $pdo;

    public static function getPdo(): PDO
    {
        if (isset(self::$pdo)) {
            return self::$pdo;
        }

        return self::$pdo = new PDO("mysql:host=db;port=3306;dbname=my_database", "user", "adler");
    }
}