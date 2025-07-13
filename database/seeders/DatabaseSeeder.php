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
<<<<<<< HEAD
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
=======
>>>>>>> origin/hung
        $this->call([
            UserSeeder::class,
            GenreSeeder::class,
            MovieSeeder::class,
<<<<<<< HEAD
            CinemasTableSeeder::class,
            RoomsTableSeeder::class,
            GenreSeeder::class,
            BookingSeeder::class,
            MovieSeeder::class
=======
            CinemasSeeder::class,
            RoomSeeder::class,
            PromotionSeeder::class,
            BookingSeeder::class,
            ReviewSeeder::class,
>>>>>>> origin/hung
        ]);
    }
}
