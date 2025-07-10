<?php

namespace Database\Seeders;

use App\Models\Cinemas;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            GenreSeeder::class,
            MovieSeeder::class,
            CinemasSeeder::class,
            RoomSeeder::class,
            PromotionSeeder::class,
            BookingSeeder::class,
            ReviewSeeder::class,
            EmailTemplateSeeder::class,
        ]);
    }
}
