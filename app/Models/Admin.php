<?php

namespace App\Models;

use PDO;

class Admin
{
    private static string $table = 'admins';

    public function __construct(protected PDO $db)
    {
    }

    /**
     * @param string $name
     * @param string $password
     * @param string $email
     * @return void
     */
    public function create(string $name, string $password, string $email)
    {
        // Hash the password before storing it
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $this->db->prepare("INSERT INTO admins (name, password, email) VALUES (?, ?, ?)");
        $stmt->execute([$name, $hashedPassword, $email]);
    }

    /**
     * @return array|false
     */
    public static function getAll(): bool|array
    {
        $pdo = self::getDB();
        $stmt = $pdo->query('SELECT * FROM ' . self::$table);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * @param string $email
     * @return string|null
     */
    public function getHashedPassword(string $email): ?string
    {
        $stmt = $this->db->prepare("SELECT password FROM admins WHERE email = ?");
        $stmt->execute([$email]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? $row['password'] : null;
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
