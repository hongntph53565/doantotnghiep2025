<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PromotionFactory extends Factory
{
    public function definition(): array
    {
        $faker = $this->faker;

        $startDate = $faker->dateTimeBetween('-1 month', '+1 week');
        $endDate = (clone $startDate)->modify('+' . rand(7, 30) . ' days');

        return [
            // 'pro_code' => strtoupper(Str::random(8)),
            // 'min_order_amount' => $faker->numberBetween(50000, 500000),// tiền tối thiểu
            // 'discount_percentage' => $faker->numberBetween(5, 50),
            // // giảm 5% – 50%
            // 'quantity' => $faker->numberBetween(50, 500), // tổng số lượt phát hành
            'used' => $faker->numberBetween(0, 50), // số lượt đã dùng
            'limit_per_user' => $faker->numberBetween(1, 500), // giới hạn lượt mỗi người dùng
            'start_date' => $startDate->format('Y-m-d'),
            'end_date' => $endDate->format('Y-m-d'),
            'status' => $faker->randomElement(['active', 'inactive', 'expired']),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
