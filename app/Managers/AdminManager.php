<?php

namespace App\Models;

use App\Core\Database;
use PDO;

class Admin
{
    private static string $table = 'admins';
    protected PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function create(array $data): void
    {
        $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);
        $stmt = $this->db->prepare("INSERT INTO admins (name, email, password) VALUES (?, ?, ?)");
        $stmt->execute([$data['name'], $data['email'], $hashedPassword]);
    }

    public static function getAll(): array
    {
        $db = Database::getInstance();
        $stmt = $db->query('SELECT * FROM ' . self::$table);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getHashedPassword(string $email): ?string
    {
        $stmt = $this->db->prepare("SELECT password FROM admins WHERE email = ?");
        $stmt->execute([$email]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? $row['password'] : null;
    }
}
