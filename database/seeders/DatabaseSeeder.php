<?php

namespace Database\Seeders;

use App\Models\CinemasTableSeeder;
use App\Models\User;
use Database\Seeders\CinemasTableSeeder as SeedersCinemasTableSeeder;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call([
            UserSeeder::class,
            GenreSeeder::class,
            MovieSeeder::class,
            SeedersCinemasTableSeeder::class,
            RoomsTableSeeder::class,
            GenreSeeder::class,
            // BookingSeeder::class,
            MovieSeeder::class
        ]);
    }
}