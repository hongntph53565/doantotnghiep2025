<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('food_drinks', function (Blueprint $table) {
            $table->id('item_id');
            $table->string('item_name', 100)->nullable();
            $table->decimal('price', 10, 2)->nullable();
            $table->tinyInteger('combo_type');
            $table->enum('status', ['Available', 'Out of Stock'])->default('Available');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('food_drinks');
    }
};
