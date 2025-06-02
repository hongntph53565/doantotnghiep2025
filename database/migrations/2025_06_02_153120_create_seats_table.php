<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('seats', function (Blueprint $table) {
            $table->id('seat_id');
            $table->foreignId('room_id')->nullable()->constrained('rooms', 'room_id');
            $table->string('seat_number', 10)->nullable();
            $table->enum('seat_type', ['Standard', 'VIP', 'Couple'])->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seats');
    }
};
