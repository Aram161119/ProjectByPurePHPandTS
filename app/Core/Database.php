<?php

namespace App\Core;

use Exception;
use PDO;
use PDOException;

class Database
{
    private static ?PDO $instance = null;
    private static string $dsn = 'mysql:host=mysql;port=3306;dbname=your_database';
    private static string $username = 'your_username';
    private static string $password = 'your_password';

    private function __construct() {}
    private function __clone() {}

    /**
     * @throws Exception
     */
    public function __wakeup()
    {
        throw new Exception("Cannot unserialize a singleton.");
    }

    /**
     * Get the PDO instance
     *
     * @return PDO
     */
    public static function getInstance(): PDO
    {
        if (self::$instance === null) {
            try {
                self::$instance = new PDO(self::$dsn, self::$username, self::$password);
                self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die('Database connection failed: ' . $e->getMessage());
            }
        }

        return self::$instance;
    }
}
