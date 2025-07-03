<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Room;

class RoomsTableSeeder extends Seeder
{
    public function run(): void
    {
        Room::insert([
            [
                'cinema_id' => 1,
                'room_name' => 'Phòng chiếu 1',
                'total_seats' => 120,
                'created_at' => now(),
            ]
        ]);
    }
}
