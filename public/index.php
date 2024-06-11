<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Controllers\AdminController;
use App\Controllers\AuthController;
use App\Controllers\HomeController;
use App\Controllers\ProductController;
use App\Core\ErrorResponse;
use App\Core\Router;
use App\Middleware\AuthMiddleware;

/**
 * Error and Exception handling
 */
error_reporting(E_ALL);

/**
 *  Sessions
 */
session_start();

/**
 * Routing
 */
$router = new Router();

$router->add('POST', '/login', [AuthController::class, 'login']);

$router->group([
    ['GET', '/', [HomeController::class, 'index']],
    ['POST', '/logout', [AuthController::class, 'logout']],
    ['GET', '/admin', [AdminController::class, 'index']],
    ['POST', '/admin/create', [AdminController::class, 'create']],
    ['POST', '/admin/store', [AdminController::class, 'store']],
    ['POST', '/products/store', [ProductController::class, 'store']],
    ['GET', '/products', [ProductController::class, 'index']],
    ['POST', '/import-products', [ProductController::class, 'import']],
], AuthMiddleware::class);

try {
    echo $router->dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
} catch (\Throwable $e) {
    ErrorResponse::handle($e);
}