<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('booking_qrcodes', function (Blueprint $table) {
            $table->id('qr_id');
            $table->foreignId('booking_id')->constrained('bookings', 'booking_id');
            $table->string('qr_code', 255);
            $table->enum('qr_type', ['Ticket', 'Invoice'])->default('Ticket');
            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('expired_at')->nullable();
            $table->boolean('is_printed')->default(false);
            $table->dateTime('printed_at')->nullable();
            $table->foreignId('printed_by')->nullable()->constrained('users', 'user_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('booking_qrcodes');
    }
};
