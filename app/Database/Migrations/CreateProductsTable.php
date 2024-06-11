<?php

namespace App\Database\Migrations;

use App\Core\Database;

class CreateProductsTable
{
    /**
     * @return void
     */
    public static function up()
    {
        $pdo = Database::getInstance();

        $sql = "
            CREATE TABLE IF NOT EXISTS products (
                id INT AUTO_INCREMENT PRIMARY KEY,
                admin_id INT NOT NULL,
                name VARCHAR(255) NOT NULL,
                type INT NOT NULL,
                price DECIMAL(10, 2) NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (admin_id) REFERENCES admins(id) ON DELETE CASCADE ON UPDATE CASCADE
            );
        ";

        $pdo->exec($sql);
    }
}
