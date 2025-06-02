<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('genres', function (Blueprint $table) {
            $table->id('genre_id');
            $table->string('genre_name', 100)->unique();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('genres');
    }
};
