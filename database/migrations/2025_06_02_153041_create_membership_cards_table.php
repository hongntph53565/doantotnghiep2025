<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('membership_cards', function (Blueprint $table) {
            $table->id('card_id');
            $table->foreignId('user_id')->nullable()->constrained('users', 'user_id');
            $table->enum('card_type', ['Silver', 'Gold', 'Platinum'])->nullable();
            $table->integer('points')->default(0);
            $table->date('issue_date')->nullable();
            $table->date('expiry_date')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('membership_cards');
    }
};
