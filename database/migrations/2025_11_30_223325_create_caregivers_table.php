<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('caregivers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('child_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('relationship', ['parent', 'grandparent', 'guardian', 'daycare', 'pediatrician', 'other']);
            $table->enum('access_level', ['full', 'view_only', 'collaborative']);
            $table->boolean('can_edit')->default(false);
            $table->boolean('is_primary')->default(false);
            $table->timestamps();
            
            $table->unique(['child_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('caregivers');
    }
};