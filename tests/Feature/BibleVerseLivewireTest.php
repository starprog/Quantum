<?php

namespace Tests\Feature;

use App\Models\Verse;
use App\Models\VerseCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Modules\BibleVerse\src\Http\Livewire\BibleVerse as BibleVerseLivewire;
use Tests\TestCase;

class BibleVerseLivewireTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seedTestData();
    }

    protected function seedTestData()
    {
        $peace = VerseCategory::create([
            'name' => 'Peace',
            'description' => 'Verses about peace'
        ]);

        $hope = VerseCategory::create([
            'name' => 'Hope',
            'description' => 'Verses about hope'
        ]);

        Verse::create([
            'reference' => 'John 3:16',
            'verse' => 'For God so loved the world that he gave his one and only Son.',
            'category_id' => $hope->id,
        ]);

        Verse::create([
            'reference' => 'Philippians 4:7',
            'verse' => 'And the peace of God will guard your hearts.',
            'category_id' => $peace->id,
        ]);

        Verse::create([
            'reference' => 'Romans 15:13',
            'verse' => 'May the God of hope fill you with all joy and peace.',
            'category_id' => $hope->id,
        ]);
    }

    public function test_component_loads_with_initial_verse()
    {
        Livewire::test(BibleVerseLivewire::class)
            ->assertSet('verse', function ($verse) {
                return $verse !== null;
            })
            ->assertSet('categories', function ($categories) {
                return count($categories) === 2;
            });
    }

    public function test_refresh_verse_gets_new_verse()
    {
        Livewire::test(BibleVerseLivewire::class)
            ->call('refreshVerse')
            ->assertSet('verse', function ($verse) {
                return $verse !== null;
            })
            ->assertSet('loading', false);
    }

    public function test_refresh_verse_with_category_filters_correctly()
    {
        Livewire::test(BibleVerseLivewire::class)
            ->call('refreshVerse', 'Peace')
            ->assertSet('selectedCategory', 'Peace')
            ->assertSet('verse', function ($verse) {
                return $verse !== null && $verse->category->name === 'Peace';
            });
    }

    public function test_search_finds_verses()
    {
        Livewire::test(BibleVerseLivewire::class)
            ->set('searchTerm', 'peace')
            ->call('search')
            ->assertSet('isSearching', true)
            ->assertSet('verses', function ($verses) {
                return count($verses) > 0;
            });
    }

    public function test_search_with_empty_term_shows_random_verse()
    {
        Livewire::test(BibleVerseLivewire::class)
            ->set('searchTerm', '')
            ->call('search')
            ->assertSet('isSearching', false)
            ->assertSet('verses', [])
            ->assertSet('verse', function ($verse) {
                return $verse !== null;
            });
    }

    public function test_clear_search_resets_state()
    {
        Livewire::test(BibleVerseLivewire::class)
            ->set('searchTerm', 'peace')
            ->call('search')
            ->assertSet('isSearching', true)
            ->call('clearSearch')
            ->assertSet('searchTerm', '')
            ->assertSet('verses', [])
            ->assertSet('isSearching', false);
    }

    public function test_select_verse_from_search_results()
    {
        $verse = Verse::first();

        Livewire::test(BibleVerseLivewire::class)
            ->set('searchTerm', 'peace')
            ->call('search')
            ->call('selectVerse', $verse->id)
            ->assertSet('verse', function ($selectedVerse) use ($verse) {
                return $selectedVerse->id === $verse->id;
            })
            ->assertSet('isSearching', false);
    }

    public function test_search_clears_when_refreshing_verse()
    {
        Livewire::test(BibleVerseLivewire::class)
            ->set('searchTerm', 'peace')
            ->call('search')
            ->call('refreshVerse')
            ->assertSet('searchTerm', '')
            ->assertSet('verses', [])
            ->assertSet('isSearching', false);
    }

    public function test_component_renders_successfully()
    {
        Livewire::test(BibleVerseLivewire::class)
            ->assertStatus(200)
            ->assertViewIs('bible-verse.livewire.bible-verse');
    }
}
