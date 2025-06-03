<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('booking_promotions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('booking_id');
            $table->unsignedBigInteger('promo_id');
            $table->decimal('discount_amount', 10, 2)->nullable();
            $table->timestamps();

            $table->foreign('booking_id')->references('booking_id')->on('bookings')->onDelete('cascade');
            $table->foreign('promo_id')->references('promo_id')->on('promotions')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('booking_promotions');
    }
};
