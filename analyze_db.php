<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

$tables = array_map(function($t) { return array_values((array)$t)[0]; }, DB::select('SHOW TABLES'));
$report = [];

foreach($tables as $table) {
    if (in_array($table, ['migrations', 'password_reset_tokens', 'personal_access_tokens', 'failed_jobs'])) continue;
    
    $columns = Schema::getColumnListing($table);
    $rowCount = DB::table($table)->count();
    
    $columnStats = [];
    foreach($columns as $col) {
        $nullCount = DB::table($table)->whereNull($col)->orWhere($col, '')->count();
        $columnStats[$col] = [
            'type' => Schema::getColumnType($table, $col),
            'null_count' => $nullCount
        ];
    }
    
    $report[$table] = [
        'rows' => $rowCount,
        'columns' => $columnStats
    ];
}

echo json_encode($report, JSON_PRETTY_PRINT);
