<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Database\Migrations\CreateAdminsTable;
use App\Database\Migrations\CreateProductsTable;

// List of migration classes to run
$migrations = [
    CreateAdminsTable::class,
    CreateProductsTable::class,
];

foreach ($migrations as $migration) {
    echo "Running migration: " . $migration . "\n";
    $migration::up();
    echo "Migration " . $migration . " completed.\n";
}
