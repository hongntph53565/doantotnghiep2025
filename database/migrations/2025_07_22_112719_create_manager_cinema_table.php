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
        Schema::create('manager_cinema', function (Blueprint $table) {
            // Khóa ngoại
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('cinema_id');

            // Timestamps (created_at, updated_at)
            $table->timestamps();

            // Composite primary key
            $table->primary(['user_id', 'cinema_id']);

            // Ràng buộc khóa ngoại
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
            $table->foreign('cinema_id')->references('cinema_id')->on('cinemas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('manager_cinema');
    }
};
