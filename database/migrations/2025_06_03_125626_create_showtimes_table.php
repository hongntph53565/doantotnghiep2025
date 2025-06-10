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
        Schema::create('showtimes', function (Blueprint $table) {
            $table->bigIncrements('showtime_id');

            $table->unsignedBigInteger('movie_id');
            $table->unsignedBigInteger('room_id');

            $table->dateTime('start_time');
            $table->dateTime('end_time')->nullable();

            $table->decimal('price', 8, 2);
            $table->enum('status', ['active', 'cancelled', 'sold_out'])->default('active');

            $table->timestamps();

            // Khóa ngoại phải chỉ rõ tên cột và bảng nếu không theo chuẩn 'id'
            $table->foreign('movie_id')->references('movie_id')->on('movies')->onDelete('cascade');
            $table->foreign('room_id')->references('room_id')->on('rooms')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('showtimes');
    }
};
