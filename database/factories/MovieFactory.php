<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class MovieFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(3),
            'duration' => $this->faker->numberBetween(60, 180),
            'director' => $this->faker->name,
            'cast' => $this->faker->name,
            'release_date' => $this->faker->date(),
            'end_date' => $this->faker->date(),
            'poster' => $this->faker->imageUrl(),
            'trailer' => $this->faker->url(),
            'genre_id' => 1, // hoặc random
            'age_rating' => 'P',
            'format' => '2D',
            'language' => 'Phụ đề',
            'description' => $this->faker->paragraph,
        ];
    }
}

