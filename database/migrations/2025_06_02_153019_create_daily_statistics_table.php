<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('daily_statistics', function (Blueprint $table) {
            $table->id('stat_id');
            $table->date('stat_date')->unique();
            $table->integer('total_showtime')->default(0);
            $table->integer('total_booking')->default(0);
            $table->decimal('total_revenue', 15, 2)->default(0.00);
            $table->decimal('food_revenue', 15, 2)->default(0.00);
            $table->decimal('ticket_revenue', 15, 2)->default(0.00);
            $table->integer('total_customers')->default(0);
            $table->decimal('occupancy_rate', 5, 2)->default(0.00);
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('daily_statistics');
    }
};
