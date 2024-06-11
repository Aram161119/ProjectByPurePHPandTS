<?php

namespace App\Managers;

use App\Core\BaseManager;
use App\Models\Admin;

class AdminManager extends BaseManager
{
    public function __construct()
    {
        $model = new Admin();
        parent::__construct($model);
    }

    /**
     * @param string $email
     * @return string|null
     */
    public function getHashedPassword(string $email): ?string
    {
        $result = $this->model->query("SELECT password FROM " . Admin::$table . " WHERE email = ?", [$email]);
        return $result ? $result[0]['password'] : null;
    }

    /**
     * @param array $fields
     * @return bool
     */
    public function create(array $fields): bool
    {
        $admin = $this->model->query("SELECT * FROM " . Admin::$table . " WHERE email = ?", [$fields['email']]);

        if (!$admin) {
            return parent::create($fields);
        }

        return false;
    }
}
