<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::create('time_entries', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->timestamp('clock_in');
        $table->timestamp('clock_out')->nullable();
        $table->timestamps();
    });
}
public function down()
{
    Schema::dropIfExists('time_entries');
}
};
