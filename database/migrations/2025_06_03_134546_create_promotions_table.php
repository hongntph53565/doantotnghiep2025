<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('promotions', function (Blueprint $table) {
            $table->bigIncrements('pro_id');
            $table->string('pro_code')->unique(); // Mã voucher

            $table->unsignedInteger('min_order_amount'); // Số tiền tối thiểu
            $table->unsignedTinyInteger('discount_percentage'); // Giảm theo phần trăm
            // Khi tính tiền: giá gốc * (discount_percentage / 100)

            $table->integer('quantity')->default(0); // Tổng số mã phát hành
            $table->integer('used')->default(0); // Đã sử dụng bao nhiêu lượt
            $table->integer('limit_per_user')->nullable(); // Giới hạn số lượt mỗi người

            $table->date('start_date');
            $table->date('end_date');

            $table->enum('status', ['active', 'inactive', 'expired'])->default('active');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('promotions');
        Schema::dropSoftDeletes();
    }
};
