<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ReviewsFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => $this->faker->randomNumber(),, 'movie_id' => $this->faker->randomNumber(),, 'rating' => $this->faker->randomNumber(),, 'comment' => $this->faker->randomNumber(),, 'created_at' => $this->faker->randomNumber(),
        ];
    }
}
