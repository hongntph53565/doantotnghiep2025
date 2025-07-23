<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('showtimes', function (Blueprint $table) {
            $table->unsignedBigInteger('cinema_id')->after('room_id');

            $table->foreign('cinema_id')->references('cinema_id')->on('cinemas')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('showtimes', function (Blueprint $table) {
            $table->dropForeign(['cinema_id']);
            $table->dropColumn('cinema_id');
        });
    }
};
