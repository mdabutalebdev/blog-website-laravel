<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$db = App\Core\Database::getInstance();
try {
    $db->query('SELECT 1 FROM books LIMIT 1');
    echo "Table 'books' exists.\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

try {
    $db->query('SELECT 1 FROM comment_likes LIMIT 1');
    echo "Table 'comment_likes' exists.\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
