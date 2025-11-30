<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    $c = App\Models\Content::latest()->first();
    if ($c) {
        echo "Latest Content: {$c->title}\n";
        echo "Thumbnail URL: " . ($c->thumbnail_url ?? 'NULL') . "\n";
    } else {
        echo "No content found.\n";
    }
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
