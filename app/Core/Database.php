<?php

namespace App\Core;

use Illuminate\Support\Facades\DB;
use PDO;

class Database {
    public static function getInstance(): PDO {
        $pdo = DB::connection()->getPdo();
        // Ensure fetch mode is associative like the old PDO setup likely had
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        return $pdo;
    }
}
