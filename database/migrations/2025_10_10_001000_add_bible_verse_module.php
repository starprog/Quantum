<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Only insert if modules table exists (optional feature)
        if (Schema::hasTable('modules')) {
            DB::table('modules')->insert([
                'name' => 'BibleVerse',
                'path' => 'modules/BibleVerse',
                'enabled' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }

    public function down()
    {
        // Only delete if modules table exists
        if (Schema::hasTable('modules')) {
            DB::table('modules')->where('name', 'BibleVerse')->delete();
        }
    }
};