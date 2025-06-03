<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('membership_cards', function (Blueprint $table) {
            $table->bigIncrements('card_id');
            $table->unsignedBigInteger('user_id');
            $table->string('card_number')->unique();
            $table->enum('card_type', ['silver', 'gold', 'platinum'])->default('silver');
            $table->integer('points')->default(0);
            $table->timestamp('issued_date')->nullable();
            $table->timestamp('expired_date')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('membership_cards');
    }
};
