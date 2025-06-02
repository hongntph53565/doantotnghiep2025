<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class HolidaysFactory extends Factory
{
    public function definition(): array
    {
        return [
            'holiday_date' => $this->faker->randomNumber(),, 'holiday_name' => $this->faker->randomNumber(),, 'price_multiplier' => $this->faker->randomNumber(),
        ];
    }
}
