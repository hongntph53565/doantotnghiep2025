<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CinemasFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->randomNumber(),, 'address_detail' => $this->faker->randomNumber(),, 'ward' => $this->faker->randomNumber(),, 'district' => $this->faker->randomNumber(),, 'province' => $this->faker->randomNumber(),, 'phone' => $this->faker->randomNumber(),, 'created_at' => $this->faker->randomNumber(),
        ];
    }
}
