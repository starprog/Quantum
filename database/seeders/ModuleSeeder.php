<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ModuleSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('modules')->updateOrInsert(
            ['path' => 'modules/Hello'],
            [
                'name' => 'hello',
                'provider' => 'Modules\\Hello\\HelloServiceProvider',
                'enabled' => 1,
                'settings' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }
}
