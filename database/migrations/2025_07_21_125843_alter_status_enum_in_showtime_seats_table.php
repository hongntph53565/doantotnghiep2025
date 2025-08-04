<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use Illuminate\Support\Facades\DB;
return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up(): void
{
    DB::statement("ALTER TABLE showtime_seats MODIFY status ENUM('available', 'booked', 'pending') DEFAULT 'available'");
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('showtime_seats', function (Blueprint $table) {
            //
        });
    }
};
