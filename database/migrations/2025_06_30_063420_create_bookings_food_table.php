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
        Schema::create('booking_food', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('booking_id');
            $table->unsignedBigInteger('food_id');
            $table->integer('quantity')->default(1);

            $table->timestamps();

            // Khóa ngoại
            $table->foreign('booking_id')->references('booking_id')->on('bookings')->onDelete('cascade');
            $table->foreign('food_id')->references('food_id')->on('foods')->onDelete('cascade');

            // Ràng buộc không trùng booking + food (mỗi booking chỉ có 1 dòng cho mỗi food)
            $table->unique(['booking_id', 'food_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings_food');
    }
};
