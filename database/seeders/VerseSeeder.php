<?php

namespace Database\Seeders;

use App\Models\Verse;
use App\Models\VerseCategory;
use Illuminate\Database\Seeder;

class VerseSeeder extends Seeder
{
    public function run(): void
    {
        $categories = VerseCategory::all()->keyBy("name");

        $verses = [
            [
                "reference" => "John 3:16",
                "verse" => "For God so loved the world that he gave his one and only Son, that whoever believes in him shall not perish but have eternal life.",
                "category_id" => $categories["Gospel & Salvation"]->id
            ],
            [
                "reference" => "Hebrews 11:1",
                "verse" => "Now faith is confidence in what we hope for and assurance about what we do not see.",
                "category_id" => $categories["Faith & Trust"]->id
            ],
            [
                "reference" => "1 Corinthians 13:13",
                "verse" => "And now these three remain: faith, hope and love. But the greatest of these is love.",
                "category_id" => $categories["Love & Compassion"]->id
            ],
            [
                "reference" => "Romans 15:13",
                "verse" => "May the God of hope fill you with all joy and peace as you trust in him, so that you may overflow with hope by the power of the Holy Spirit.",
                "category_id" => $categories["Hope & Encouragement"]->id
            ],
            [
                "reference" => "John 14:27",
                "verse" => "Peace I leave with you; my peace I give you. I do not give to you as the world gives. Do not let your hearts be troubled and do not be afraid.",
                "category_id" => $categories["Peace & Comfort"]->id
            ]
        ];

        foreach ($verses as $verse) {
            Verse::create($verse);
        }
    }
}