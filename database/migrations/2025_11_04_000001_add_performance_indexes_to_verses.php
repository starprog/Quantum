<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Adds indexes to improve query performance for:
     * - Random verse selection
     * - Category filtering
     * - Verse search by reference
     * - Category lookups by name
     */
    public function up(): void
    {
        Schema::table('verses', function (Blueprint $table) {
            // Index for category filtering (used in getVersesByCategory and category-based random)
            $table->index('category_id', 'idx_verses_category_id');
            
            // Index for reference search (used in searchVerses)
            $table->index('reference', 'idx_verses_reference');
        });

        Schema::table('verse_categories', function (Blueprint $table) {
            // Index for category lookup by name (used in getRandomVerse with category filter)
            $table->index('name', 'idx_verse_categories_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('verses', function (Blueprint $table) {
            $table->dropIndex('idx_verses_category_id');
            $table->dropIndex('idx_verses_reference');
        });

        Schema::table('verse_categories', function (Blueprint $table) {
            $table->dropIndex('idx_verse_categories_name');
        });
    }
};
