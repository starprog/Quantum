<?php

namespace Database\Seeders;

use App\Models\VerseCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class VerseCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Gospel & Salvation',
                'description' => 'Verses about salvation and the gospel message'
            ],
            [
                'name' => 'Faith & Trust',
                'description' => 'Verses about having faith and trusting in God'
            ],
            [
                'name' => 'Strength & Courage',
                'description' => 'Verses about finding strength and courage in God'
            ],
            [
                'name' => 'Peace & Comfort',
                'description' => 'Verses about finding peace and comfort in God'
            ],
            [
                'name' => 'Love & Compassion',
                'description' => 'Verses about love, compassion, and caring for others'
            ],
            [
                'name' => 'Love & Relationships',
                'description' => 'Verses about love and relationships'
            ],
            [
                'name' => 'Wisdom & Guidance',
                'description' => 'Verses about wisdom and seeking guidance'
            ],
            [
                'name' => 'Hope & Encouragement',
                'description' => 'Verses about finding hope and encouragement'
            ],
            [
                'name' => 'Prayer & Worship',
                'description' => 'Verses about prayer and worship'
            ],
            [
                'name' => 'Grace & Forgiveness',
                'description' => 'Verses about grace and forgiveness'
            ]
        ];

        foreach ($categories as $category) {
            VerseCategory::create([
                'name' => $category['name'],
                'description' => $category['description']
            ]);
        }
    }
}
