<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$db = App\Core\Database::getInstance();
try {
    $db->query("ALTER TABLE books ADD COLUMN cover_image VARCHAR(255) NULL AFTER pdf_path");
    echo "Added cover_image column to books table.\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
