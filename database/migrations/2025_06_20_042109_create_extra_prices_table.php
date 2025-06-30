<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('extra_prices', function (Blueprint $table) {
            $table->id('extra_price_id');
            $table->enum('day_type', ['weekday', 'weekend', 'holiday']);
            $table->date('date')->nullable();
            $table->unsignedTinyInteger('percentage');
            $table->string('description')->nullable();
            $table->timestamps();

            $table->unique(['day_type', 'date']);
        });

if (DB::table('extra_prices')->count() === 0) {
    DB::table('extra_prices')->insert([
        [
            'day_type'    => 'weekend',
            'date'        => null,
            'percentage'  => 20,
            'description' => 'cuối tuần',
            'created_at'  => now(),
            'updated_at'  => now(),
        ],
    ]);
}

    }

    public function down(): void
    {
        Schema::dropIfExists('extra_prices');
    }
};
