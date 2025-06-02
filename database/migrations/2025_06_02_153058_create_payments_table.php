<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id('payment_id');
            $table->foreignId('booking_id')->nullable()->constrained('bookings', 'booking_id');
            $table->enum('payment_method', ['Cash', 'Credit Card', 'E-Wallet'])->nullable();
            $table->decimal('amount', 10, 2)->nullable();
            $table->dateTime('payment_date')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
