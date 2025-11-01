<?php

require __DIR__.'/../vendor/autoload.php';

$app = require_once __DIR__.'/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "\n=== Bible Verse Database Statistics ===\n\n";

$categories = App\Models\VerseCategory::withCount('verses')->orderBy('name')->get();

echo "Total Categories: " . $categories->count() . "\n";
echo "Total Verses: " . App\Models\Verse::count() . "\n\n";

echo "Breakdown by Category:\n";
echo str_repeat("-", 50) . "\n";

foreach ($categories as $category) {
    printf("%-30s %3d verses\n", $category->name, $category->verses_count);
}

echo str_repeat("-", 50) . "\n";
echo "\nDatabase successfully populated!\n\n";
