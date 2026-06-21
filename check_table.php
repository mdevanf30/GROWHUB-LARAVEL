<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$dbType = DB::select("SHOW COLUMNS FROM project WHERE Field = 'category'")[0]->Type;
echo "Column Type: " . $dbType . "\n";
