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
        Schema::create('devotional_plan_verses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('devotional_plan_id')->constrained()->onDelete('cascade');
            $table->foreignId('verse_id')->constrained()->onDelete('cascade');
            $table->integer('day_number');
            $table->text('reflection_text')->nullable();
            $table->timestamps();
            
            // Ensure each day in a plan has only one verse
            $table->unique(['devotional_plan_id', 'day_number']);
            
            $table->index('devotional_plan_id');
            $table->index('day_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('devotional_plan_verses');
    }
};
