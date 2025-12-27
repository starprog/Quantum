<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('heroes', function (Blueprint $table) {
            $table->string('rarity')->default('common')->after('universe'); // common, rare, legendary
            $table->string('special_ability')->nullable()->after('rarity');
            $table->string('special_description')->nullable()->after('special_ability');
            $table->text('bio')->nullable()->after('special_description');
            $table->string('image')->nullable()->after('bio');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('heroes', function (Blueprint $table) {
            $table->dropColumn(['rarity', 'special_ability', 'special_description', 'bio', 'image']);
        });
    }
};