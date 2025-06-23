<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Movie;
use App\Models\Genre;

class MovieSeeder extends Seeder
{
    public function run(): void
    {
        $genres = Genre::all();
        $ageRatings = ['P', 'T13', 'T18'];
        $formats = ['2D', '3D', 'IMAX'];
        $languages = ['Tiếng Việt', 'Tiếng Anh', 'Tiếng Hàn', 'Tiếng Nhật'];

        foreach (range(1, 10) as $i) {
            $releaseDate = fake()->dateTimeBetween('-1 years', 'now');
            $endDate = fake()->dateTimeBetween($releaseDate, '+3 months');

            Movie::create([
                'genre_id' => $genres->random()->genre_id,
                'title' => fake()->sentence(3),
                'duration' => fake()->numberBetween(80, 180), // phút
                'director' => fake()->name(),
                'cast' => fake()->name() . ', ' . fake()->name(),
                'release_date' => $releaseDate,
                'end_date' => $endDate,
                'poster' => fake()->imageUrl(400, 600, 'movies', true),
                'trailer' => 'https://www.youtube.com/watch?v=' . fake()->lexify('???????????'),
                'age_rating' => fake()->randomElement($ageRatings),
                'format' => fake()->randomElement($formats),
                'language' => fake()->randomElement($languages),
                'description' => fake()->paragraph(3),
            ]);
        }
    }
}
