<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('ticket_price_rules', function (Blueprint $table) {
            $table->id('rule_id');
            $table->foreignId('cinema_id')->constrained('cinemas', 'cinema_id');
            $table->enum('seat_type', ['Standard', 'VIP', 'Couple']);
            $table->enum('day_type', ['Weekday', 'Weekend', 'Holiday']);
            $table->decimal('base_price', 10, 2);
            $table->boolean('is_active')->default(true);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ticket_price_rules');
    }
};
