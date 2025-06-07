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
        Schema::create('movies', function (Blueprint $table) {
            $table->bigIncrements('movie_id'); // Khóa chính tự tăng
            $table->unsignedBigInteger('genre_id'); // Khóa ngoại

            $table->string('title', 255);
            $table->integer('duration')->unsigned(); // thời lượng phút, không âm
            $table->string('director', 100)->nullable();
            $table->text('cast')->nullable();
            $table->date('release_date');
            $table->date('end_date')->nullable();

<<<<<<< HEAD
            $table->string('poster',255)->nullable();
            $table->string('trailer',255)->nullable();
            $table->string('age_rating', 10);
=======
            $table->string('poster', 255)->nullable();
            $table->string('trailer', 255)->nullable();
            $table->enum('age_rating', ['P', 'T13', 'T18']);
>>>>>>> hong
            $table->enum('format', ['2D', '3D', 'IMAX'])->nullable();
            $table->enum('language', ['Tiếng Việt', 'Tiếng Anh', 'Tiếng Hàn', 'Tiếng Nhật']);
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Foreign Key
            $table->foreign('genre_id')->references('genre_id')->on('genres')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movies');
        Schema::dropSoftDeletes();
    }
};
