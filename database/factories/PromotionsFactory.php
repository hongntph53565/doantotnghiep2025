<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PromotionsFactory extends Factory
{
    public function definition(): array
    {
        return [
            'promo_code' => $this->faker->randomNumber(),, 'discount_percentage' => $this->faker->randomNumber(),, 'start_date' => $this->faker->randomNumber(),, 'end_date' => $this->faker->randomNumber(),, 'status' => $this->faker->randomNumber(),
        ];
    }
}
