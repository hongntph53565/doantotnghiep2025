<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('cinema_seat_type_prices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cinema_id');
            $table->unsignedBigInteger('seat_type_id');
            $table->unsignedInteger('price');
            $table->timestamps();

            $table->foreign('cinema_id')->references('cinema_id')->on('cinemas')->onDelete('cascade');
            $table->foreign('seat_type_id')->references('seat_type_id')->on('seat_types')->onDelete('cascade');
            $table->unique(['cinema_id', 'seat_type_id']); // mỗi rạp chỉ có 1 giá cho mỗi loại ghế
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cinema_seat_type_prices');
    }
};
