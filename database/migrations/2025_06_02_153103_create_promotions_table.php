<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('promotions', function (Blueprint $table) {
            $table->id('promo_id');
            $table->string('promo_code', 50)->nullable()->unique();
            $table->decimal('discount_percentage', 5, 2)->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->enum('status', ['Active', 'Inactive'])->default('Active');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('promotions');
    }
};
