<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('movie_statistics', function (Blueprint $table) {
            $table->id('stat_id');
            $table->foreignId('movie_id')->constrained('movies', 'movie_id');
            $table->integer('total_showtime')->default(0);
            $table->integer('total_booking')->default(0);
            $table->decimal('total_revenue', 15, 2)->default(0);
            $table->integer('total_customers')->default(0);
            $table->decimal('average_rating', 3, 1)->default(0.0);
            $table->decimal('occupancy_rate', 5, 2)->default(0.00);
            $table->date('start_date');
            $table->date('end_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('movie_statistics');
    }
};
