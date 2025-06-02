<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CinemaStatisticsFactory extends Factory
{
    public function definition(): array
    {
        return [
            'cinema_id' => $this->faker->randomNumber(),, 'stat_date' => $this->faker->randomNumber(),, 'total_showtime' => $this->faker->randomNumber(),, 'total_revenue' => $this->faker->randomNumber(),, 'food_revenue' => $this->faker->randomNumber(),, 'ticket_revenue' => $this->faker->randomNumber(),, 'total_customers' => $this->faker->randomNumber(),
        ];
    }
}
