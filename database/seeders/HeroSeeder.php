<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Hero;

class HeroSeeder extends Seeder
{
    public function run(): void
    {
        $heroes = [
            // Marvel Heroes
            ['slug' => 'thor', 'name' => 'Thor', 'universe' => 'Marvel', 'strength' => 9, 'powers' => 8, 'durability' => 9, 'endurance' => 8],
            ['slug' => 'hulk', 'name' => 'Hulk', 'universe' => 'Marvel', 'strength' => 10, 'powers' => 6, 'durability' => 10, 'endurance' => 9],
            ['slug' => 'iron-man', 'name' => 'Iron Man', 'universe' => 'Marvel', 'strength' => 6, 'powers' => 9, 'durability' => 7, 'endurance' => 6],
            ['slug' => 'spider-man', 'name' => 'Spider-Man', 'universe' => 'Marvel', 'strength' => 7, 'powers' => 7, 'durability' => 6, 'endurance' => 7],
            ['slug' => 'dr-strange', 'name' => 'Doctor Strange', 'universe' => 'Marvel', 'strength' => 5, 'powers' => 10, 'durability' => 6, 'endurance' => 6],
            ['slug' => 'black-widow', 'name' => 'Black Widow', 'universe' => 'Marvel', 'strength' => 5, 'powers' => 5, 'durability' => 5, 'endurance' => 7],
            ['slug' => 'storm', 'name' => 'Storm', 'universe' => 'Marvel', 'strength' => 5, 'powers' => 8, 'durability' => 5, 'endurance' => 6],
            ['slug' => 'namor', 'name' => 'Namor', 'universe' => 'Marvel', 'strength' => 8, 'powers' => 6, 'durability' => 7, 'endurance' => 7],
            ['slug' => 'luke-cage', 'name' => 'Luke Cage', 'universe' => 'Marvel', 'strength' => 7, 'powers' => 4, 'durability' => 8, 'endurance' => 7],
            ['slug' => 'captain-america', 'name' => 'Captain America', 'universe' => 'Marvel', 'strength' => 7, 'powers' => 5, 'durability' => 7, 'endurance' => 8],

            // DC Heroes
            ['slug' => 'superman', 'name' => 'Superman', 'universe' => 'DC', 'strength' => 10, 'powers' => 9, 'durability' => 10, 'endurance' => 10],
            ['slug' => 'batman', 'name' => 'Batman', 'universe' => 'DC', 'strength' => 5, 'powers' => 3, 'durability' => 5, 'endurance' => 6],
            ['slug' => 'wonder-woman', 'name' => 'Wonder Woman', 'universe' => 'DC', 'strength' => 9, 'powers' => 7, 'durability' => 9, 'endurance' => 9],
            ['slug' => 'flash', 'name' => 'The Flash', 'universe' => 'DC', 'strength' => 5, 'powers' => 8, 'durability' => 5, 'endurance' => 9],
            ['slug' => 'aquaman', 'name' => 'Aquaman', 'universe' => 'DC', 'strength' => 8, 'powers' => 6, 'durability' => 8, 'endurance' => 7],
            ['slug' => 'green-lantern', 'name' => 'Green Lantern', 'universe' => 'DC', 'strength' => 7, 'powers' => 9, 'durability' => 7, 'endurance' => 8],
            ['slug' => 'cyborg', 'name' => 'Cyborg', 'universe' => 'DC', 'strength' => 7, 'powers' => 7, 'durability' => 8, 'endurance' => 7],
            ['slug' => 'martian-manhunter', 'name' => 'Martian Manhunter', 'universe' => 'DC', 'strength' => 9, 'powers' => 9, 'durability' => 8, 'endurance' => 8],
            ['slug' => 'shazam', 'name' => 'Shazam', 'universe' => 'DC', 'strength' => 9, 'powers' => 8, 'durability' => 8, 'endurance' => 8],
            ['slug' => 'vixen', 'name' => 'Vixen', 'universe' => 'DC', 'strength' => 6, 'powers' => 7, 'durability' => 6, 'endurance' => 6],
        ];

        foreach ($heroes as $hero) {
            Hero::updateOrCreate(
                ['slug' => $hero['slug']],
                $hero
            );
        }
    }
}