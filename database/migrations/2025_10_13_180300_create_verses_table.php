<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('verses', function (Blueprint $table) {
            $table->id();
            $table->string('reference');
            $table->text('verse');
            $table->foreignId('category_id')->constrained('verse_categories');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('verses');
    }
};