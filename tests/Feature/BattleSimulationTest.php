<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Hero;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BattleSimulationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Seed test heroes
        Hero::create(['slug' => 'thor', 'name' => 'Thor', 'universe' => 'Marvel', 'strength' => 9, 'powers' => 8, 'durability' => 9, 'endurance' => 8]);
        Hero::create(['slug' => 'superman', 'name' => 'Superman', 'universe' => 'DC', 'strength' => 10, 'powers' => 9, 'durability' => 10, 'endurance' => 10]);
        Hero::create(['slug' => 'batman', 'name' => 'Batman', 'universe' => 'DC', 'strength' => 5, 'powers' => 3, 'durability' => 5, 'endurance' => 6]);
        Hero::create(['slug' => 'hulk', 'name' => 'Hulk', 'universe' => 'Marvel', 'strength' => 10, 'powers' => 6, 'durability' => 10, 'endurance' => 9]);
    }

    public function test_battle_endpoint_returns_valid_response(): void
    {
        $response = $this->postJson('/api/battles/toptrumps', [
            'deckA' => ['thor', 'hulk'],
            'deckB' => ['superman', 'batman'],
        ]);

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'winner',
                     'rounds',
                     'history' => [
                         '*' => ['round', 'attribute', 'a', 'b', 'winner', 'sizeA', 'sizeB']
                     ],
                     'remaining' => ['A', 'B']
                 ]);
 
        $this->assertContains($response->json('winner'), ['A', 'B', 'stalemate']);
        $this->assertIsInt($response->json('rounds'));
        $this->assertTrue($response->json('rounds') > 0);
    }

    public function test_battle_requires_both_decks(): void
    {
        $response = $this->postJson('/api/battles/toptrumps', [
            'deckA' => ['thor'],
        ]);

        $response->assertStatus(422)
                 ->assertJson(['error' => 'Both decks are required']);
    }

    public function test_battle_filters_invalid_heroes(): void
    {
        $response = $this->postJson('/api/battles/toptrumps', [
            'deckA' => ['thor', 'invalid-hero'],
            'deckB' => ['superman'],
        ]);

        $response->assertStatus(200);
        // Should still work with valid heroes only
    }
}