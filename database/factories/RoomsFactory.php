<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class RoomsFactory extends Factory
{
    public function definition(): array
    {
        return [
            'cinema_id' => $this->faker->randomNumber(),, 'room_name' => $this->faker->randomNumber(),, 'total_seats' => $this->faker->randomNumber(),, 'created_at' => $this->faker->randomNumber(),
        ];
    }
}
