<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class HolidayPriceRulesFactory extends Factory
{
    public function definition(): array
    {
        return [
            'holiday_id' => $this->faker->randomNumber(),, 'cinema_id' => $this->faker->randomNumber(),, 'seat_type' => $this->faker->randomNumber(),, 'special_price' => $this->faker->randomNumber(),
        ];
    }
}
