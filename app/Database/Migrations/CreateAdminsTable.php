<?php

namespace App\Database\Migrations;

use PDO;

class CreateAdminsTable
{
    /**
     * @return void
     */
    public static function up()
    {
        $pdo = self::getDB();

        $sql = "
            CREATE TABLE IF NOT EXISTS admins (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(255) NOT NULL,
                email VARCHAR(255) NOT NULL UNIQUE,
                password VARCHAR(255) NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                deleted_at TIMESTAMP DEFAULT NULL 
            );
        ";

        $pdo->exec($sql);
    }

    /**
     * @return PDO
     */
    private static function getDB(): PDO
    {
        // Adjust the DSN, username, and password as needed
        $dsn = 'mysql:host=mysql;port=3306;dbname=your_database';
        $username = 'your_username';
        $password = 'your_password';

        return new PDO($dsn, $username, $password);
    }
}
