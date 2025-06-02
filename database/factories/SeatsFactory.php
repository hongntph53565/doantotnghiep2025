<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SeatsFactory extends Factory
{
    public function definition(): array
    {
        return [
            'room_id' => $this->faker->randomNumber(),, 'seat_number' => $this->faker->randomNumber(),, 'seat_type' => $this->faker->randomNumber(),
        ];
    }
}
