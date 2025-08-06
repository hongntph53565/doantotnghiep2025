<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
public function up(): void
{
    Schema::create('seat_types', function (Blueprint $table) {
        $table->id('seat_type_id');
        $table->enum('name', ['standard', 'vip', 'couple'])->unique();
        $table->timestamps();
    });

    if (DB::table('seat_types')->count() === 0) {
        DB::table('seat_types')->insert([
            ['name' => 'standard', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'vip', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'couple', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}

    public function down(): void
    {
        Schema::dropIfExists('seat_types');
    }
};