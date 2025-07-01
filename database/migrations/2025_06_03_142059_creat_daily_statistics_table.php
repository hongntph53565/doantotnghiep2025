<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('daily_statistics', function (Blueprint $table) {
            $table->bigIncrements('stat_id');
            $table->integer('total_showtime');
            $table->integer('total_booking');
            $table->decimal('total_revenue', 15, 2);
            $table->decimal('food_revenue', 15, 2);
            $table->decimal('ticket_revenue', 15, 2);
            $table->integer('total_customers');
            $table->decimal('occupancy_rate', 5, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('daily_statistics');
    }
};
