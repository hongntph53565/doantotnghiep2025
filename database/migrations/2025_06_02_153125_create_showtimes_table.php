<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('showtimes', function (Blueprint $table) {
            $table->id('showtime_id');
            $table->foreignId('movie_id')->nullable()->constrained('movies', 'movie_id');
            $table->foreignId('room_id')->nullable()->constrained('rooms', 'room_id');
            $table->date('show_date')->nullable();
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->decimal('price', 10, 2)->nullable();
            $table->enum('status', ['upcoming', 'completed', 'archived'])->default('upcoming');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('showtimes');
    }
};
