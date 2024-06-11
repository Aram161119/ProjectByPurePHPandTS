<?php

namespace App\Managers;

use App\Core\BaseManager;
use App\Models\Product;

class ProductManager extends BaseManager
{
    public function __construct()
    {
        $model = new Product();
        parent::__construct($model);
    }

    public function import(int $adminId, array $data)
    {

    }
}
