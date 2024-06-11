<?php

namespace App\Core;

use PDO;

abstract class Model
{
    protected PDO $db;

    protected static string $table;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * @param array $data
     * @return bool
     */
    public function create(array $data): bool
    {
        $columns = implode(', ', array_keys($data));
        $placeholders = implode(', ', array_fill(0, count($data), '?'));

        $sql = "INSERT INTO " . static::$table . " ($columns) VALUES ($placeholders)";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute(array_values($data));
    }

    /**
     * @param array $search
     * @param array $sorting
     * @return array
     */
    public function get(array $search, array $sorting): array
    {
        $sql = "SELECT * FROM " . static::$table;
        $params = [];

        if (!empty($search)) {
            $conditions = [];
            foreach ($search as $column => $condition) {
                if (is_array($condition)) {
                    [$operator, $value] = $condition;
                    $conditions[] = "$column $operator :$column";
                    $params[$column] = $value;
                } else {
                    $conditions[] = "$column = :$column";
                    $params[$column] = $condition;
                }
            }
            $sql .= " WHERE " . implode(' AND ', $conditions);
        }

        if (!empty($sorting)) {
            $orderBy = [];
            foreach ($sorting as $column => $direction) {
                $orderBy[] = "$column $direction";
            }
            $sql .= " ORDER BY " . implode(', ', $orderBy);
        }

        $stmt = $this->db->prepare($sql);

        foreach ($params as $param => $value) {
            $stmt->bindValue(":$param", $value);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function update(int $id, array $data): bool
    {
        $columns = implode(' = ?, ', array_keys($data)) . ' = ?';
        $sql = "UPDATE " . static::$table . " SET $columns WHERE id = ?";

        $stmt = $this->db->prepare($sql);
        $values = array_values($data);
        $values[] = $id;

        return $stmt->execute($values);
    }

    /**
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        $sql = "DELETE FROM " . static::$table . " WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$id]);
    }

    /**
     * @param int $id
     * @return array|null
     */
    public function findById(int $id): ?array
    {
        $sql = "SELECT * FROM " . static::$table . " WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }

    /**
     * @param array $data
     * @return array|null
     */
    public function find(array $data): ?array
    {
        $field = $data['field'];
        $operator = $data['operator'];

        $sql = "SELECT * FROM " . static::$table . " WHERE $field $operator ?";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$data['value']]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ?: null;
    }

    /**
     * @param string $sql
     * @param array $params
     * @return array|bool
     */
    public function query(string $sql, array $params = []): array|bool
    {
        $stmt = $this->db->prepare($sql);
        if ($stmt->execute($params)) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        return false;
    }
}
