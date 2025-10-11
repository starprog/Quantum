<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBibleVersesTable extends Migration
{
    public function up()
    {
        Schema::create('bible_verses', function (Blueprint $table) {
            $table->id();
            $table->text('verse');
            $table->string('reference');
            $table->string('book');
            $table->integer('chapter');
            $table->integer('verse_number');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bible_verses');
    }
}