<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
<<<<<<< HEAD
Schema::create('payments', function (Blueprint $table) {
    $table->bigIncrements('payment_id');
    $table->unsignedBigInteger('booking_id');
    
    $table->enum('payment_method', ['cash', 'payos', 'zalopay', 'vnpay']);
    $table->decimal('price_amount', 10, 2);
    $table->enum('status', ['unpaid', 'paid', 'failed', 'cancelled'])->default('unpaid');

    $table->string('transaction_id')->nullable(); // Mã bạn sinh ra (vnp_TxnRef, orderCode, etc.)
    $table->string('gateway_transaction_id')->nullable(); // Mã thật từ cổng thanh toán
    $table->string('payment_url')->nullable(); // Link redirect (nếu có)
    $table->timestamp('paid_at')->nullable(); // Thời điểm thanh toán thành công

    $table->timestamps();

    $table->foreign('booking_id')->references('booking_id')->on('bookings')->onDelete('cascade');
});
=======
        Schema::create('payments', function (Blueprint $table) {
            $table->bigIncrements('payment_id');
            $table->unsignedBigInteger('booking_id');
            $table->enum('payment_method', ['cash', 'payos', 'momo']);
            $table->decimal('price_amount', 10, 2);
            $table->enum('status', ['paid', 'unpaid'])->default('unpaid');
            $table->timestamps();

            $table->foreign('booking_id')->references('booking_id')->on('bookings')->onDelete('cascade');
        });
>>>>>>> origin/hung
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
