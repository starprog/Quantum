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
        Schema::create('collection_verses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('verse_collection_id')->constrained()->onDelete('cascade');
            $table->foreignId('verse_id')->constrained()->onDelete('cascade');
            $table->integer('order')->default(0);
            $table->timestamps();
            
            // Ensure a verse can only be in a collection once
            $table->unique(['verse_collection_id', 'verse_id']);
            
            // Add indexes
            $table->index('verse_collection_id');
            $table->index('verse_id');
            $table->index('order');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('collection_verses');
    }
};
