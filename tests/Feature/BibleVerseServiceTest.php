<?php

namespace Tests\Feature;

use App\Models\Verse;
use App\Models\VerseCategory;
use App\Services\BibleVerseService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BibleVerseServiceTest extends TestCase
{
    use RefreshDatabase;

    protected BibleVerseService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new BibleVerseService();
        
        // Seed test data
        $this->seedTestData();
    }

    protected function seedTestData()
    {
        // Create categories
        $peace = VerseCategory::create([
            'name' => 'Peace',
            'description' => 'Verses about peace'
        ]);

        $hope = VerseCategory::create([
            'name' => 'Hope',
            'description' => 'Verses about hope'
        ]);

        // Create verses
        Verse::create([
            'reference' => 'John 3:16',
            'verse' => 'For God so loved the world that he gave his one and only Son, that whoever believes in him shall not perish but have eternal life.',
            'category_id' => $hope->id,
        ]);

        Verse::create([
            'reference' => 'Philippians 4:7',
            'verse' => 'And the peace of God, which transcends all understanding, will guard your hearts and your minds in Christ Jesus.',
            'category_id' => $peace->id,
        ]);

        Verse::create([
            'reference' => 'Romans 15:13',
            'verse' => 'May the God of hope fill you with all joy and peace as you trust in him.',
            'category_id' => $hope->id,
        ]);
    }

    public function test_get_all_verses_returns_collection()
    {
        $verses = $this->service->getAllVerses();

        $this->assertCount(3, $verses);
        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Collection::class, $verses);
    }

    public function test_get_verses_by_category_filters_correctly()
    {
        $hopeCategory = VerseCategory::where('name', 'Hope')->first();
        $verses = $this->service->getVersesByCategory($hopeCategory->id);

        $this->assertCount(2, $verses);
        $verses->each(function ($verse) use ($hopeCategory) {
            $this->assertEquals($hopeCategory->id, $verse->category_id);
        });
    }

    public function test_get_all_categories_returns_all_categories()
    {
        $categories = $this->service->getAllCategories();

        $this->assertCount(2, $categories);
        $this->assertTrue($categories->contains('name', 'Peace'));
        $this->assertTrue($categories->contains('name', 'Hope'));
    }

    public function test_get_random_verse_returns_verse()
    {
        $verse = $this->service->getRandomVerse();

        $this->assertNotNull($verse);
        $this->assertInstanceOf(Verse::class, $verse);
        $this->assertNotEmpty($verse->verse);
        $this->assertNotEmpty($verse->reference);
    }

    public function test_get_random_verse_filters_by_category()
    {
        $verse = $this->service->getRandomVerse('Peace');

        $this->assertNotNull($verse);
        $this->assertEquals('Peace', $verse->category->name);
    }

    public function test_get_verse_of_the_day_returns_consistent_verse()
    {
        $verse1 = $this->service->getVerseOfTheDay();
        $verse2 = $this->service->getVerseOfTheDay();

        $this->assertNotNull($verse1);
        $this->assertNotNull($verse2);
        $this->assertEquals($verse1->id, $verse2->id, 'Verse of the day should be consistent for same day');
    }

    public function test_search_verses_finds_by_verse_text()
    {
        $results = $this->service->searchVerses('peace');

        $this->assertGreaterThan(0, $results->count());
        $results->each(function ($verse) {
            $this->assertStringContainsStringIgnoringCase('peace', $verse->verse);
        });
    }

    public function test_search_verses_finds_by_reference()
    {
        $results = $this->service->searchVerses('John');

        $this->assertCount(1, $results);
        $this->assertStringContainsString('John', $results->first()->reference);
    }

    public function test_search_verses_returns_empty_for_no_match()
    {
        $results = $this->service->searchVerses('nonexistent text');

        $this->assertCount(0, $results);
    }

    public function test_search_verses_filters_by_category()
    {
        $peaceCategory = VerseCategory::where('name', 'Peace')->first();
        $results = $this->service->searchVerses('God', $peaceCategory->id);

        $this->assertGreaterThan(0, $results->count());
        $results->each(function ($verse) use ($peaceCategory) {
            $this->assertEquals($peaceCategory->id, $verse->category_id);
        });
    }

    public function test_search_verses_returns_all_when_search_term_empty()
    {
        $results = $this->service->searchVerses('');

        $this->assertCount(3, $results);
    }

    public function test_verse_relationships_are_loaded()
    {
        $verse = $this->service->getRandomVerse();

        $this->assertTrue($verse->relationLoaded('category'));
        $this->assertNotNull($verse->category);
        $this->assertInstanceOf(VerseCategory::class, $verse->category);
    }
}
