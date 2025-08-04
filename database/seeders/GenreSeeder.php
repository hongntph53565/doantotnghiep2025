<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Genre;

class GenreSeeder extends Seeder
{
    public function run(): void
    {
        $genres = [
            'Action',
            'Romance',
            'Horror',
            'Family',
            'Musica',
            'Drama',
            'Crime',
            'Adventure',
            'Comedy',
            'Documentary'
        ];

        foreach ($genres as $name) {
            Genre::create([
                'genre_name' => $name,
                'description' => fake()->sentence(),
            ]);
        }
    }
}


