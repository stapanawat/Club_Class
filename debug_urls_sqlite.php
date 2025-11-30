<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Force SQLite connection config for this script
config(['database.default' => 'sqlite']);
config(['database.connections.sqlite.database' => database_path('database.sqlite')]);

try {
    $c1 = App\Models\Content::where('title', '414141')->first();
    $c2 = App\Models\Content::where('title', 'm, n,mn')->first();

    echo "URL1: " . ($c1 ? $c1->thumbnail_url : 'Not Found') . "\n";
    echo "URL2: " . ($c2 ? $c2->thumbnail_url : 'Not Found') . "\n";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
