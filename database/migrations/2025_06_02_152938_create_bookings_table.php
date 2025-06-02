<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id('booking_id');
            $table->foreignId('user_id')->nullable()->constrained('users', 'user_id');
            $table->foreignId('showtime_id')->nullable()->constrained('showtimes', 'showtime_id');
            $table->foreignId('seat_id')->nullable()->constrained('seats', 'seat_id');
            $table->enum('booking_status', ['Pending', 'Confirmed', 'Cancelled'])->default('Pending');
            $table->enum('payment_status', ['Pending', 'Paid', 'Refunded'])->default('Pending');
            $table->dateTime('created_at')->useCurrent();
            $table->decimal('total_amount', 10, 2)->default(0);
            $table->string('booking_code', 20);
            $table->enum('booking_source', ['web', 'counter'])->default('web');
            $table->foreignId('created_by')->nullable()->constrained('users', 'user_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
