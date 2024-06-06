<?php

namespace App\Controllers;

use App\Models\Admin;
use PDO;

class AuthController
{
    /**
     * @param PDO $db
     */
    public function __construct(private PDO $db) {}

    /**
     * @param string $email
     * @param string $password
     * @return bool
     */
    public function login(string $email, string $password): bool
    {
        $admin = new Admin($this->db);
        $hashedPassword = $admin->getHashedPassword($email);

        if ($hashedPassword && password_verify($password, $hashedPassword)) {
            $_SESSION['admin_email'] = $email;
            return true;
        }

        return false;
    }

    /**
     * @return void
     */
    public function logout(): void
    {
        unset($_SESSION['admin_email']);
    }
}
