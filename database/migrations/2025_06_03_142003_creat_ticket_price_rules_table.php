<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ticket_price_rules', function (Blueprint $table) {
            $table->bigIncrements('rule_id');
            $table->unsignedBigInteger('cinema_id');
            $table->string('seat_type', 50);
            $table->string('day_type');
            $table->decimal('base_price', 10, 2);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->foreign('cinema_id')->references('cinema_id')->on('cinemas')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ticket_price_rules');
    }
};
