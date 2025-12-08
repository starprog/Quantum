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
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->integer('min_age_months'); // Minimum age in months (0-48 for 0-4 years)
            $table->integer('max_age_months'); // Maximum age in months
            $table->enum('category', [
                'sensory', 
                'motor_skills', 
                'cognitive', 
                'language', 
                'social', 
                'creative', 
                'outdoor', 
                'music'
            ]);
            $table->string('duration')->nullable(); // e.g., "15-20 minutes"
            $table->text('materials')->nullable(); // Materials needed
            $table->text('instructions')->nullable(); // Step-by-step instructions
            $table->enum('difficulty', ['easy', 'moderate', 'challenging'])->default('easy');
            $table->text('developmental_benefits')->nullable(); // What skills it develops
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activities');
    }
};