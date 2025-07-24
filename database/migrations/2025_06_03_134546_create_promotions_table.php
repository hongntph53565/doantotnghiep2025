<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('promotions', function (Blueprint $table) {
            $table->id('promo_id');
            $table->string('discount_code')->unique();
            $table->enum('type_discount', ['percent', 'amount']);
            $table->unsignedInteger('discount_value'); // phần trăm hoặc số tiền
            $table->unsignedInteger('max_uses')->nullable(); // Số lần sử dụng tối đa
            $table->unsignedInteger('max_discount')->nullable(); // Số tiền giảm tối đa (nếu là phần trăm)
            $table->unsignedInteger('min_order_value')->nullable(); // Trị giá đơn hàng tối thiểu
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->date('start_date');
            $table->date('end_date');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('promotions');
    }
};