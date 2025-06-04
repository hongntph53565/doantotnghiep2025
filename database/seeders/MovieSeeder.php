<?php

namespace Database\Seeders;

use App\Models\Movie;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MovieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
            Movie::create([
            'genre_id'     => 1,
            'title'        => 'Avengers: Endgame',
            'duration'     => 181,
            'director'     => 'Anthony Russo, Joe Russo',
            'cast'         => 'Robert Downey Jr., Chris Evans, Scarlett Johansson',
            'release_date' => '2019-04-26',
            'end_date'     => '2019-08-01',
            'poster'       => 'endgame.jpg',
            'trailer'      => 'https://www.youtube.com/watch?v=TcMBFSGVi1c',
            'age_rating'   => '9',
            'format'       => '3D',
            'language'     => 'English',
            'description'  => 'Trận chiến cuối cùng của Avengers với Thanos',
            'created_at'   =>   now(),
            'updated_at'   =>   now(),
        ]);
    }
}
