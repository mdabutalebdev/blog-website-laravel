<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

echo "Checking tables...\n";

if (!Schema::hasTable('likes')) {
    echo "Creating likes table...\n";
    Schema::create('likes', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('post_id');
        $table->unsignedBigInteger('user_id');
        $table->timestamp('created_at')->useCurrent();
        // Ignoring foreign keys for now to avoid errors
    });
} else {
    echo "likes table exists.\n";
}

if (!Schema::hasTable('comment_likes')) {
    echo "Creating comment_likes table...\n";
    Schema::create('comment_likes', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('comment_id');
        $table->unsignedBigInteger('user_id');
        $table->timestamp('created_at')->useCurrent();
    });
} else {
    echo "comment_likes table exists.\n";
}

if (!Schema::hasColumn('comments', 'like_count')) {
    echo "Adding like_count to comments...\n";
    Schema::table('comments', function (Blueprint $table) {
        $table->integer('like_count')->default(0);
    });
}
echo "Done!\n";
