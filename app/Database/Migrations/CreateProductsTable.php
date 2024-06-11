<?php

namespace App\Database\Migrations;

use App\Core\Database;

class CreateAdminsTable
{
    /**
     * @return void
     */
    public static function up()
    {
        $pdo = Database::getInstance();

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
}
