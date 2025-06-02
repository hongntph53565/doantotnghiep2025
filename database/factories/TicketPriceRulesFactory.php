<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TicketPriceRulesFactory extends Factory
{
    public function definition(): array
    {
        return [
            'cinema_id' => $this->faker->randomNumber(),, 'seat_type' => $this->faker->randomNumber(),, 'day_type' => $this->faker->randomNumber(),, 'base_price' => $this->faker->randomNumber(),, 'is_active' => $this->faker->randomNumber(),
        ];
    }
}
