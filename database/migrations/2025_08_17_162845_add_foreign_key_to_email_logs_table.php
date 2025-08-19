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
    Schema::table('email_logs', function (Blueprint $table) {
        $table->foreign('template_id')
              ->references('template_id')
              ->on('email_templates')
              ->onDelete('cascade'); // hoặc restrict tuỳ nhu cầu
    });
}

public function down(): void
{
    Schema::table('email_logs', function (Blueprint $table) {
        $table->dropForeign(['template_id']);
    });
}

};  