<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ModuleSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('modules')->insertOrIgnore([
            'name' => 'hello',
            'path' => 'modules/Hello',
            'provider' => 'Modules\\Hello\\HelloServiceProvider',
            'enabled' => true,
            'settings' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
