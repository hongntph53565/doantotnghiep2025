<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('holiday_seat_prices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('holiday_id');
            $table->unsignedBigInteger('cinema_id');
            $table->string('seat_type', 50);
            $table->decimal('custom_price', 10, 2);
            $table->timestamps();

            $table->foreign('holiday_id')->references('holiday_id')->on('holidays')->onDelete('cascade');
            $table->foreign('cinema_id')->references('cinema_id')->on('cinemas')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('holiday_seat_prices');
    }
};
