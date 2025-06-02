<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class GenresFactory extends Factory
{
    public function definition(): array
    {
        return [
            'genre_name' => $this->faker->randomNumber(),
        ];
    }
}
