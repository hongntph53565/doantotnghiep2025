<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('booking_promotions', function (Blueprint $table) {
            $table->foreignId('booking_id')->constrained('bookings', 'booking_id');
            $table->foreignId('promo_id')->constrained('promotions', 'promo_id');
            $table->decimal('discount_amount', 10, 2)->nullable();
            $table->primary(['booking_id', 'promo_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('booking_promotions');
    }
};
