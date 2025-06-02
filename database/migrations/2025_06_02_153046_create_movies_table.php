<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('movies', function (Blueprint $table) {
            $table->id('movie_id');
            $table->string('title', 200);
            $table->integer('duration')->nullable();
            $table->string('director', 100)->nullable();
            $table->text('cast')->nullable();
            $table->date('release_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('poster', 255)->nullable();
            $table->string('trailer', 255)->nullable();
            $table->dateTime('created_at')->useCurrent();
            $table->foreignId('genre_id')->nullable()->constrained('genres', 'genre_id');
            $table->enum('age_rating', ['P', 'T13', 'T16', 'T18'])->default('P');
            $table->enum('format', ['2D', '3D', 'IMAX', '4DX'])->default('2D');
            $table->enum('language', ['Phụ đề', 'Lồng tiếng'])->default('Phụ đề');
            $table->text('description')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('movies');
    }
};
