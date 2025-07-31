<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Movie;
use App\Models\Room;

class ShowtimeFactory extends Factory
{
    public function definition(): array
    {
        $faker = $this->faker;

        return [
            'movie_id' => Movie::inRandomOrder()->first()?->movie_id ?? Movie::factory(),
            'room_id' => Room::inRandomOrder()->first()?->room_id ?? Room::factory(),
            'show_date' => $faker->dateTimeBetween('+1 day', '+1 month')->format('Y-m-d H:i:s'),
            'price' => $faker->randomFloat(2, 50000, 200000), // giá vé từ 50k–200k
            'status' => $faker->randomElement(['active', 'cancelled', 'sold_out']),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
