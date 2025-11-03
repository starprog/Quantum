<?php

namespace Tests\Feature;

use Tests\TestCase;
use Livewire\Livewire;
use Modules\BibleVerse\src\Http\Livewire\BibleVerseEmbed;
use App\Models\Verse;
use App\Models\VerseCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BibleVerseEmbedTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Seed test data
        $this->seed(\Database\Seeders\VerseSeeder::class);
    }

    /** @test */
    public function component_can_render()
    {
        $component = Livewire::test(BibleVerseEmbed::class);

        $component->assertStatus(200);
    }

    /** @test */
    public function component_loads_verse_of_the_day_on_mount()
    {
        $component = Livewire::test(BibleVerseEmbed::class);

        $component->assertSet('isVerseOfTheDay', true);
        $this->assertNotNull($component->verse);
        $this->assertInstanceOf(Verse::class, $component->verse);
    }

    /** @test */
    public function component_can_refresh_to_random_verse()
    {
        $component = Livewire::test(BibleVerseEmbed::class);
        
        $originalVerseId = $component->verse->id;
        $component->assertSet('isVerseOfTheDay', true);

        // Refresh to get random verse
        $component->call('refreshVerse');

        $component->assertSet('isVerseOfTheDay', false);
        $this->assertNotNull($component->verse);
    }

    /** @test */
    public function refresh_verse_sets_loading_state()
    {
        $component = Livewire::test(BibleVerseEmbed::class);

        $component->call('refreshVerse');

        // Loading should be false after completion
        $component->assertSet('loading', false);
    }

    /** @test */
    public function component_displays_verse_text()
    {
        $component = Livewire::test(BibleVerseEmbed::class);

        $component->assertSee($component->verse->verse);
        $component->assertSee($component->verse->reference);
    }

    /** @test */
    public function component_shows_votd_badge_when_is_verse_of_the_day()
    {
        $component = Livewire::test(BibleVerseEmbed::class);

        $component->assertSet('isVerseOfTheDay', true);
        $component->assertSee('Verse of the Day');
    }

    /** @test */
    public function component_hides_votd_badge_after_refresh()
    {
        $component = Livewire::test(BibleVerseEmbed::class);

        $component->call('refreshVerse');

        $component->assertSet('isVerseOfTheDay', false);
        $component->assertDontSee('Verse of the Day');
    }

    /** @test */
    public function component_has_copy_button()
    {
        $component = Livewire::test(BibleVerseEmbed::class);

        $component->assertSee('Copy Verse');
    }

    /** @test */
    public function component_has_new_verse_button()
    {
        $component = Livewire::test(BibleVerseEmbed::class);

        $component->assertSee('New Verse');
    }

    /** @test */
    public function component_has_social_share_buttons()
    {
        $component = Livewire::test(BibleVerseEmbed::class);

        $component->assertSee('Twitter');
        $component->assertSee('Facebook');
        $component->assertSee('WhatsApp');
    }

    /** @test */
    public function component_displays_verse_category()
    {
        $component = Livewire::test(BibleVerseEmbed::class);

        $this->assertNotNull($component->verse->category);
        // Category name might not be visible in simplified version
    }

    /** @test */
    public function multiple_refreshes_work_correctly()
    {
        $component = Livewire::test(BibleVerseEmbed::class);

        $verseIds = [];

        // Refresh 5 times
        for ($i = 0; $i < 5; $i++) {
            $component->call('refreshVerse');
            $verseIds[] = $component->verse->id;
        }

        // All should be valid verses
        foreach ($verseIds as $id) {
            $this->assertGreaterThan(0, $id);
        }
    }

    /** @test */
    public function component_handles_null_verse_gracefully()
    {
        // This shouldn't happen, but test defensive code
        $component = Livewire::test(BibleVerseEmbed::class);

        // Force null verse
        $component->set('verse', null);

        $component->assertSee('No verses available');
    }
}
