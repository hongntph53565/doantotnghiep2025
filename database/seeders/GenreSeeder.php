<?php

namespace Database\Seeders;

use App\Models\Genre;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Genre::insert([
            [
                'genre_id'     => 1,
                'genre_name'   => 'Hành động',
                'description'  => 'Phim hành động kịch tính, nhiều cảnh chiến đấu.',
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'genre_id'     => 2,
                'genre_name'   => 'Kinh dị',
                'description'  => 'Phim kinh dị với yếu tố hù dọa và hồi hộp.',
                'created_at'   => now(),
                'updated_at'   => now(),
            ]
        ]);
    }
}
