<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class BookingPromotionsFactory extends Factory
{
    public function definition(): array
    {
        return [
            'booking_id' => $this->faker->randomNumber(),
            'promo_id' => $this->faker->randomNumber(),
            'discount_amount' => $this->faker->randomFloat(2, 5, 50),
        ];
    }
}
