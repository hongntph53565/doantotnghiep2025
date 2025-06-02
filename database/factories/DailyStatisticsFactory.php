<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class DailyStatisticsFactory extends Factory
{
    public function definition(): array
    {
        return [
            'stat_date' => $this->faker->randomNumber(),, 'total_showtime' => $this->faker->randomNumber(),, 'total_booking' => $this->faker->randomNumber(),, 'total_revenue' => $this->faker->randomNumber(),, 'food_revenue' => $this->faker->randomNumber(),, 'ticket_revenue' => $this->faker->randomNumber(),, 'total_customers' => $this->faker->randomNumber(),, 'occupancy_rate' => $this->faker->randomNumber(),, 'created_at' => $this->faker->randomNumber(),
        ];
    }
}
