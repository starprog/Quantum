<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create test user
        User::factory()->create([
            "name" => "Test User",
            "email" => "test@example.com",
            "password" => bcrypt("password")
        ]);

        // Run other seeders
        $this->call([
            VerseCategorySeeder::class,
            VerseSeeder::class,
        ]);
    }
}