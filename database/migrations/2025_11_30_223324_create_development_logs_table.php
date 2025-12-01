<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('development_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('child_id')->constrained()->onDelete('cascade');
            $table->date('log_date');
            $table->enum('category', [
                'motor_skills',
                'language',
                'social_skills',
                'cognitive',
                'behavior',
                'sleep',
                'feeding',
                'general'
            ]);
            $table->string('title');
            $table->text('description');
            $table->json('media')->nullable(); // photos/videos
            $table->foreignId('logged_by')->constrained('users');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('development_logs');
    }
};