<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Database\Migrations\CreateAdminsTable;

// List of migration classes to run
$migrations = [
    CreateAdminsTable::class,
];

foreach ($migrations as $migration) {
    echo "Running migration: " . $migration . "\n";
    $migration::up();
    echo "Migration " . $migration . " completed.\n";
}
