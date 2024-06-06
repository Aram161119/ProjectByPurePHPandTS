<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Controllers\AdminController;
use App\Core\ErrorResponse;
use App\Core\Router;
use App\Controllers\HomeController;

$router = new Router();

// Определение маршрутов
$router->add('/', [HomeController::class, 'index']);

$router->add('/admin', [AdminController::class, 'index']);
$router->add('/admin/create', [AdminController::class, 'create']);
$router->add('/admin/store', [AdminController::class, 'store']);

try {
    $router->dispatch($_SERVER['REQUEST_URI']);
} catch (\Throwable $e) {
    ErrorResponse::handle($e);
}


