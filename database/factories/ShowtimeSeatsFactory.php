<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ShowtimeSeatsFactory extends Factory
{
    public function definition(): array
    {
        return [
            'showtime_id' => $this->faker->randomNumber(),, 'seat_id' => $this->faker->randomNumber(),, 'status' => $this->faker->randomNumber(),, 'created_at' => $this->faker->randomNumber(),, 'updated_at' => $this->faker->randomNumber(),
        ];
    }
}
