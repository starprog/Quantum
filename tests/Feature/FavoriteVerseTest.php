<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Verse;
use App\Models\VerseCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FavoriteVerseTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seedTestData();
    }

    protected function seedTestData()
    {
        $category = VerseCategory::create([
            'name' => 'Peace',
            'description' => 'Verses about peace'
        ]);

        Verse::create([
            'reference' => 'John 3:16',
            'verse' => 'For God so loved the world.',
            'category_id' => $category->id,
        ]);

        Verse::create([
            'reference' => 'Philippians 4:7',
            'verse' => 'And the peace of God.',
            'category_id' => $category->id,
        ]);
    }

    public function test_guests_cannot_access_favorites()
    {
        $response = $this->get('/favorites');

        $response->assertRedirect('/login');
    }

    public function test_authenticated_users_can_view_favorites_page()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/favorites');

        $response->assertStatus(200);
        $response->assertViewIs('favorites.index');
    }

    public function test_user_can_add_verse_to_favorites()
    {
        $user = User::factory()->create();
        $verse = Verse::first();

        $response = $this->actingAs($user)->post("/favorites/toggle/{$verse->id}");

        $response->assertRedirect();
        $this->assertTrue($user->favoriteVerses()->where('verse_id', $verse->id)->exists());
    }

    public function test_user_can_remove_verse_from_favorites()
    {
        $user = User::factory()->create();
        $verse = Verse::first();

        // Add to favorites first
        $user->favoriteVerses()->attach($verse->id);

        // Then remove
        $response = $this->actingAs($user)->post("/favorites/toggle/{$verse->id}");

        $response->assertRedirect();
        $this->assertFalse($user->favoriteVerses()->where('verse_id', $verse->id)->exists());
    }

    public function test_toggle_favorite_requires_authentication()
    {
        $verse = Verse::first();

        $response = $this->post("/favorites/toggle/{$verse->id}");

        $response->assertRedirect('/login');
    }

    public function test_favorites_page_shows_user_favorites()
    {
        $user = User::factory()->create();
        $verse = Verse::first();

        $user->favoriteVerses()->attach($verse->id);

        $response = $this->actingAs($user)->get('/favorites');

        $response->assertStatus(200);
        $response->assertSee($verse->reference);
        $response->assertSee($verse->verse);
    }

    public function test_favorites_page_shows_empty_state_when_no_favorites()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/favorites');

        $response->assertStatus(200);
        $response->assertSee('No favorite verses yet');
    }

    public function test_user_can_have_multiple_favorites()
    {
        $user = User::factory()->create();
        $verses = Verse::take(2)->get();

        foreach ($verses as $verse) {
            $user->favoriteVerses()->attach($verse->id);
        }

        $this->assertEquals(2, $user->favoriteVerses()->count());
    }

    public function test_favorite_relationship_works_correctly()
    {
        $user = User::factory()->create();
        $verse = Verse::first();

        $user->favoriteVerses()->attach($verse->id);

        $favorites = $user->favoriteVerses;

        $this->assertCount(1, $favorites);
        $this->assertEquals($verse->id, $favorites->first()->id);
    }
}
