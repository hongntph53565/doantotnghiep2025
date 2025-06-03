<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('movie_statistics', function (Blueprint $table) {
            $table->bigIncrements('stat_id');
            $table->unsignedBigInteger('movie_id');
            $table->integer('total_showtime');
            $table->integer('total_booking');
            $table->decimal('total_revenue', 15, 2); // Ghi đúng chính tả là `revenue` nếu cần
            $table->integer('total_customer');
            $table->decimal('average_rating', 3, 2);
            $table->decimal('occupancy_rate', 5, 2);
            $table->timestamps();

            $table->foreign('movie_id')->references('movie_id')->on('movies')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('movie_statistics');
    }
};
