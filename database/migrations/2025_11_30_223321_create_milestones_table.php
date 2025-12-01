<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('milestones', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->enum('category', [
                'physical',
                'cognitive',
                'language',
                'social_emotional',
                'fine_motor',
                'gross_motor'
            ]);
            $table->integer('typical_age_months_min');
            $table->integer('typical_age_months_max');
            $table->enum('age_range', ['0-3', '3-6', '6-9', '9-12', '12-18', '18-24', '24-36', '36-48']);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('milestones');
    }
};