<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('showtime_seats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('showtime_id')->constrained('showtimes', 'showtime_id')->onDelete('cascade');
            $table->foreignId('seat_id')->constrained('seats', 'seat_id')->onDelete('cascade');
            $table->enum('status', ['available', 'booked'])->default('available');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
            $table->unique(['showtime_id', 'seat_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('showtime_seats');
    }
};
