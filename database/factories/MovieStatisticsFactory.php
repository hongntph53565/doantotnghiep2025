<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class MovieStatisticsFactory extends Factory
{
    public function definition(): array
    {
        return [
            'movie_id' => $this->faker->randomNumber(),, 'total_showtime' => $this->faker->randomNumber(),, 'total_booking' => $this->faker->randomNumber(),, 'total_revenue' => $this->faker->randomNumber(),, 'total_customers' => $this->faker->randomNumber(),, 'average_rating' => $this->faker->randomNumber(),, 'occupancy_rate' => $this->faker->randomNumber(),, 'start_date' => $this->faker->randomNumber(),, 'end_date' => $this->faker->randomNumber(),
        ];
    }
}
