<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Movie;

class ReviewFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::inRandomOrder()->value('user_id') ?? User::factory(),
            'movie_id' => Movie::inRandomOrder()->value('movie_id') ?? Movie::factory(),
            'rating' => $this->faker->numberBetween(1, 5),
            'comment' => $this->faker->optional()->sentence(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
