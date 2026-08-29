<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

$tables = DB::select('SHOW TABLES');
foreach ($tables as $t) {
    $tbl = current((array)$t);
    try {
        $count = DB::table($tbl)->count();
        echo "Table `{$tbl}`: {$count} rows" . PHP_EOL;
    } catch (\Exception $e) {
        echo "Table `{$tbl}`: Error ({$e->getMessage()})" . PHP_EOL;
    }
}
