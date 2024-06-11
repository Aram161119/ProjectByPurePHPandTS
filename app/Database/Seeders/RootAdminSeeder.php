<?php

namespace App\Database\Seeders;

use App\Managers\AdminManager;

class RootAdminSeeder
{
    /**
     * @return void
     */
    public static function seed()
    {
        $password = password_hash('123456', PASSWORD_BCRYPT);

        $data = [
            'name' => 'admin',
            'password' => $password,
            'email' => 'aram.m@invo.am'
        ];

        (new AdminManager())->create($data);

        echo "Root admin seeded successfully.\n";
    }
}
