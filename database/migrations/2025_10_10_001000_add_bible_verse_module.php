<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        DB::table('modules')->insert([
            'name' => 'BibleVerse',
            'path' => 'modules/BibleVerse',
            'enabled' => true,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }

    public function down()
    {
        DB::table('modules')->where('name', 'BibleVerse')->delete();
    }
};