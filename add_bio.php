<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

if (!Schema::hasColumn('users', 'bio')) {
    echo "Adding bio column to users...\n";
    Schema::table('users', function (Blueprint $table) {
        $table->text('bio')->nullable();
    });
}
echo "Done!\n";
