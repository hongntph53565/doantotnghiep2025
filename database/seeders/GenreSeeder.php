<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Genre;

class GenreSeeder extends Seeder
{
    public function run(): void
    {
        $genres = ['Hành động', 'Tình cảm', 'Kinh dị', 'Hài hước', 'Khoa học viễn tưởng'];

        foreach ($genres as $name) {
            Genre::create([
                'genre_name' => $name,
                'description' => fake()->sentence(),
            ]);
        }
    }
}
