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
        Schema::create('verse_audio', function (Blueprint $table) {
            $table->id();
            $table->foreignId('verse_id')->constrained('verses')->onDelete('cascade');
            $table->string('language', 10)->default('en'); // Language code (en, es, fr, etc.)
            $table->string('version', 50); // Bible version (KJV, NIV, ESV, etc.)
            $table->string('narrator', 100)->nullable(); // Narrator name
            $table->string('audio_url'); // Path or URL to audio file
            $table->string('file_format', 10)->default('mp3'); // mp3, wav, ogg
            $table->integer('duration')->nullable(); // Duration in seconds
            $table->bigInteger('file_size')->nullable(); // File size in bytes
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            // Indexes for efficient lookups
            $table->index(['verse_id', 'language', 'version']);
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('verse_audio');
    }
};
