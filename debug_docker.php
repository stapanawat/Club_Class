<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    $items = ['414141', 'm, n,mn', 'kkk'];
    foreach ($items as $title) {
        $c = App\Models\Content::where('title', $title)->first();
        echo "Title: $title\n";
        echo "URL: " . ($c ? "'{$c->thumbnail_url}'" : 'Not Found') . "\n";
        echo "--------------------------------\n";
    }
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
