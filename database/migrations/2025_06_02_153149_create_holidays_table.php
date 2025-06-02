<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('holidays', function (Blueprint $table) {
            $table->id('holiday_id');
            $table->date('holiday_date');
            $table->string('holiday_name', 100);
            $table->decimal('price_multiplier', 3, 2)->default(1.50);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('holidays');
    }
};
