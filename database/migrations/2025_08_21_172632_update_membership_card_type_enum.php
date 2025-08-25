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
        Schema::table('membership_cards', function (Blueprint $table) {
            // Cần cài doctrine/dbal để change enum
            $table->enum('card_type', ['normal', 'silver', 'gold', 'platinum'])
                  ->default('normal')
                  ->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('membership_cards', function (Blueprint $table) {
            $table->enum('card_type', ['silver', 'gold', 'platinum'])
                  ->default('silver')
                  ->change();
        });
    }
};
