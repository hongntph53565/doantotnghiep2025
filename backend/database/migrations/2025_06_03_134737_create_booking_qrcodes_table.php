<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('booking_qrcodes', function (Blueprint $table) {
            $table->bigIncrements('qr_id');
            $table->unsignedBigInteger('booking_id');
            $table->string('qr_code');
            $table->string('qr_type');
            $table->enum('status', ['active', 'used', 'expired'])->default('active');
            $table->integer('usage_count')->default(0);
            $table->boolean('is_printed')->default(false);
            $table->timestamp('created_at')->nullable();
            $table->timestamp('expired_at')->nullable();
            $table->string('printed_by')->nullable();
            $table->string('printed_location')->nullable();
            // $table->timestamps();

            $table->foreign('booking_id')->references('booking_id')->on('bookings')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('booking_qrcodes');
    }
};
