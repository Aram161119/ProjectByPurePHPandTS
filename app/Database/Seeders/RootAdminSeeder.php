<?php

namespace App\Database\Seeders;

use App\Models\Admin;
use PDO;

class RootAdminSeeder
{
    /**
     * @return void
     */
    public static function seed()
    {
        $dsn = 'mysql:host=mysql;port=3306;dbname=your_database';
        $username = 'your_username';
        $password = 'your_password';

        $db = new PDO($dsn, $username, $password);

        $name = 'admin';
        $password = '123456';
        $email = 'aram.m@invo.am';

        $admin = new Admin($db);
        $admin->create($name, $password, $email);

        echo "Root admin seeded successfully.\n";
    }
}
