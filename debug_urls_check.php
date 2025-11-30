<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Force SQLite connection config for this script
config(['database.default' => 'sqlite']);
config(['database.connections.sqlite.database' => database_path('database.sqlite')]);

try {
    $items = ['414141', 'm, n,mn', 'kkk', 'bhbh'];
    foreach ($items as $title) {
        $c = App\Models\Content::where('title', $title)->first();
        echo "Title: $title\n";
        echo "Thumbnail URL: " . ($c ? "'{$c->thumbnail_url}'" : 'Not Found') . "\n";
        echo "--------------------------------\n";
    }
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
