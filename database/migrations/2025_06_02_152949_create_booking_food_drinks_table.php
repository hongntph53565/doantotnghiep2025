<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('booking_food_drinks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->nullable()->constrained('bookings', 'booking_id');
            $table->foreignId('item_id')->nullable()->constrained('food_drinks', 'item_id');
            $table->integer('quantity')->default(1);
            $table->decimal('price', 10, 2)->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('booking_food_drinks');
    }
};
