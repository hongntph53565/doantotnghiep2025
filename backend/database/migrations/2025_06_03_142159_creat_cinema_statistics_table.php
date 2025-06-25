<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cinema_statistics', function (Blueprint $table) {
            $table->bigIncrements('stat_id');
            $table->unsignedBigInteger('cinema_id');
            $table->date('stat_date');
            $table->integer('total_showtime');
            $table->decimal('total_revenue', 15, 2);
            $table->decimal('food_revenue', 15, 2);
            $table->decimal('ticket_revenue', 15, 2);
            $table->integer('total_customers');
            $table->timestamps();

            $table->foreign('cinema_id')->references('cinema_id')->on('cinemas')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cinema_statistics');
    }
};
