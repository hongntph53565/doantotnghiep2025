<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('cinema_statistics', function (Blueprint $table) {
            $table->id('stat_id');
            $table->foreignId('cinema_id')->constrained('cinemas', 'cinema_id');
            $table->date('stat_date');
            $table->integer('total_showtime')->default(0);
            $table->decimal('total_revenue', 15, 2)->default(0.00);
            $table->decimal('food_revenue', 15, 2)->default(0.00);
            $table->decimal('ticket_revenue', 15, 2)->default(0.00);
            $table->integer('total_customers')->default(0);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cinema_statistics');
    }
};
