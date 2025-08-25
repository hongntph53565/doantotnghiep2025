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
    Schema::table('rooms', function (Blueprint $table) {
        $table->string('format')->after('room_name')->default('2D');
    });
}

public function down(): void
{
    Schema::table('rooms', function (Blueprint $table) {
        $table->dropColumn('format');
    });
}

};
