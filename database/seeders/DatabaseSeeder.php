<?php

namespace Database\Seeders;

use App\Models\User;
<<<<<<< HEAD
=======
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
>>>>>>> origin/Spencer-Verses
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
<<<<<<< HEAD
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
=======
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
}
>>>>>>> origin/Spencer-Verses
