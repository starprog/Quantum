<?php

namespace Database\Seeders;

use App\Models\VerseCategory;
use Illuminate\Database\Seeder;

class VerseCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ["name" => "Gospel & Salvation", "description" => "Verses about salvation and the gospel message"],
            ["name" => "Faith & Trust", "description" => "Verses about having faith and trusting in God"],
            ["name" => "Love & Compassion", "description" => "Verses about love and showing compassion"],
            ["name" => "Hope & Encouragement", "description" => "Verses about hope and encouragement"],
            ["name" => "Peace & Comfort", "description" => "Verses about finding peace and comfort in God"]
        ];

        foreach ($categories as $category) {
            VerseCategory::create($category);
        }
    }
}