<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('time_slots', function (Blueprint $table) {
            $table->id('time_slot_id');
            $table->string('name');
            $table->time('start_time');
            $table->time('end_time');
            $table->unsignedTinyInteger('extra_percentage')->default(0);
            $table->timestamps();
        });

        if (DB::table('time_slots')->count() === 0) {
            DB::table('time_slots')->insert([
                [
                    'name' => 'Sáng',
                    'start_time' => '06:00:00',
                    'end_time' => '11:59:59',
                    'extra_percentage' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Chiều',
                    'start_time' => '12:00:00',
                    'end_time' => '17:59:59',
                    'extra_percentage' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Tối',
                    'start_time' => '18:00:00',
                    'end_time' => '23:59:59',
                    'extra_percentage' => 15,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Khuya',
                    'start_time' => '00:00:00',
                    'end_time' => '05:59:59',
                    'extra_percentage' => 10,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('time_slots');
    }
};