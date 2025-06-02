<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ShowtimesFactory extends Factory
{
    public function definition(): array
    {
        return [
            'movie_id' => $this->faker->randomNumber(),, 'room_id' => $this->faker->randomNumber(),, 'show_date' => $this->faker->randomNumber(),, 'start_time' => $this->faker->randomNumber(),, 'end_time' => $this->faker->randomNumber(),, 'price' => $this->faker->randomNumber(),, 'status' => $this->faker->randomNumber(),
        ];
    }
}
