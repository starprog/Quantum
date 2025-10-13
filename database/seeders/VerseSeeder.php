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
            // Gospel & Salvation
            [
                "reference" => "John 3:16",
                "verse" => "For God so loved the world that he gave his one and only Son, that whoever believes in him shall not perish but have eternal life.",
                "category_id" => $categories["Gospel & Salvation"]->id
            ],
            [
                "reference" => "Romans 10:9",
                "verse" => "If you declare with your mouth, 'Jesus is Lord,' and believe in your heart that God raised him from the dead, you will be saved.",
                "category_id" => $categories["Gospel & Salvation"]->id
            ],
            [
                "reference" => "Acts 4:12",
                "verse" => "Salvation is found in no one else, for there is no other name under heaven given to mankind by which we must be saved.",
                "category_id" => $categories["Gospel & Salvation"]->id
            ],
            [
                "reference" => "Ephesians 2:8-9",
                "verse" => "For it is by grace you have been saved, through faith—and this is not from yourselves, it is the gift of God—not by works, so that no one can boast.",
                "category_id" => $categories["Gospel & Salvation"]->id
            ],

            // Faith & Trust
            [
                "reference" => "Hebrews 11:1",
                "verse" => "Now faith is confidence in what we hope for and assurance about what we do not see.",
                "category_id" => $categories["Faith & Trust"]->id
            ],
            [
                "reference" => "Proverbs 3:5-6",
                "verse" => "Trust in the Lord with all your heart and lean not on your own understanding; in all your ways submit to him, and he will make your paths straight.",
                "category_id" => $categories["Faith & Trust"]->id
            ],
            [
                "reference" => "2 Corinthians 5:7",
                "verse" => "For we live by faith, not by sight.",
                "category_id" => $categories["Faith & Trust"]->id
            ],
            [
                "reference" => "Mark 11:22-24",
                "verse" => "Have faith in God. Truly I tell you, if anyone says to this mountain, 'Go, throw yourself into the sea,' and does not doubt in their heart but believes that what they say will happen, it will be done for them.",
                "category_id" => $categories["Faith & Trust"]->id
            ],

            // Love & Compassion
            [
                "reference" => "1 Corinthians 13:13",
                "verse" => "And now these three remain: faith, hope and love. But the greatest of these is love.",
                "category_id" => $categories["Love & Compassion"]->id
            ],
            [
                "reference" => "1 John 4:7-8",
                "verse" => "Dear friends, let us love one another, for love comes from God. Everyone who loves has been born of God and knows God. Whoever does not love does not know God, because God is love.",
                "category_id" => $categories["Love & Compassion"]->id
            ],
            [
                "reference" => "Colossians 3:12",
                "verse" => "Therefore, as God's chosen people, holy and dearly loved, clothe yourselves with compassion, kindness, humility, gentleness and patience.",
                "category_id" => $categories["Love & Compassion"]->id
            ],
            [
                "reference" => "1 Peter 4:8",
                "verse" => "Above all, love each other deeply, because love covers over a multitude of sins.",
                "category_id" => $categories["Love & Compassion"]->id
            ],

            // Hope & Encouragement
            [
                "reference" => "Romans 15:13",
                "verse" => "May the God of hope fill you with all joy and peace as you trust in him, so that you may overflow with hope by the power of the Holy Spirit.",
                "category_id" => $categories["Hope & Encouragement"]->id
            ],
            [
                "reference" => "Jeremiah 29:11",
                "verse" => "For I know the plans I have for you, declares the Lord, plans to prosper you and not to harm you, plans to give you hope and a future.",
                "category_id" => $categories["Hope & Encouragement"]->id
            ],
            [
                "reference" => "Isaiah 40:31",
                "verse" => "But those who hope in the Lord will renew their strength. They will soar on wings like eagles; they will run and not grow weary, they will walk and not be faint.",
                "category_id" => $categories["Hope & Encouragement"]->id
            ],
            [
                "reference" => "Philippians 4:13",
                "verse" => "I can do all things through Christ who gives me strength.",
                "category_id" => $categories["Hope & Encouragement"]->id
            ],

            // Peace & Comfort
            [
                "reference" => "John 14:27",
                "verse" => "Peace I leave with you; my peace I give you. I do not give to you as the world gives. Do not let your hearts be troubled and do not be afraid.",
                "category_id" => $categories["Peace & Comfort"]->id
            ],
            [
                "reference" => "Philippians 4:6-7",
                "verse" => "Do not be anxious about anything, but in every situation, by prayer and petition, with thanksgiving, present your requests to God. And the peace of God, which transcends all understanding, will guard your hearts and your minds in Christ Jesus.",
                "category_id" => $categories["Peace & Comfort"]->id
            ],
            [
                "reference" => "Psalm 23:4",
                "verse" => "Even though I walk through the darkest valley, I will fear no evil, for you are with me; your rod and your staff, they comfort me.",
                "category_id" => $categories["Peace & Comfort"]->id
            ],
            [
                "reference" => "Matthew 11:28-29",
                "verse" => "Come to me, all you who are weary and burdened, and I will give you rest. Take my yoke upon you and learn from me, for I am gentle and humble in heart, and you will find rest for your souls.",
                "category_id" => $categories["Peace & Comfort"]->id
            ]
        ];

        foreach ($verses as $verse) {
            Verse::create($verse);
        }
    }
}