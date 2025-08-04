<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\{
    Genre, Movie, Cinema, Room, SeatType, Seat,
    Showtime, ShowtimeSeat
};

class DemoMovieSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Genre
        $genre = Genre::firstOrCreate(['genre_name' => 'Hành động'], ['status' => 'active']);

        // 2. Movie
        $movie = Movie::create([
            'genre_id' => $genre->genre_id,
            'title' => 'Avatar: Dòng chảy của nước',
            'duration' => 192,
            'director' => 'James Cameron',
            'cast' => 'Sam Worthington, Zoe Saldana',
            'release_date' => '2025-07-01',
            'poster' => 'avatar.jpg',
            'language' => 'Tiếng Anh',
            'description' => 'Bản sử thi tiếp theo của Pandora.',
            'status' => 'active'
        ]);

        // 3. Cinema
        $cinema = \App\Models\Cinema::create([
            'name' => 'LumiStar Nam Định',
            'address_detail' => '123 Trần Hưng Đạo',
            'ward' => 'Phan Đình Phùng',
            'district' => 'TP Nam Định',
            'city' => 'Nam Định',
            'phone' => '0123456789',
            'email' => 'lumistar@demo.com',
            'status' => 'active'
        ]);

        // 4. Room
        $room = Room::create([
            'cinema_id' => $cinema->cinema_id,
            'room_name' => 'Phòng 1',
            'format' => '2D',
            'total_seats' => 12
        ]);

        // 5. Seat types
        $standardType = SeatType::firstOrCreate(['name' => 'standard']);

        // 6. Seats (3 hàng × 4 ghế)
        $seats = [];
        foreach (range('A', 'C') as $row) {
            for ($i = 1; $i <= 4; $i++) {
                $seats[] = Seat::create([
                    'room_id' => $room->room_id,
                    'seat_code' => $row . $i,
                    'seat_type_id' => $standardType->seat_type_id
                ]);
            }
        }

        // 7. Showtime (hôm nay 19:30–21:50)
        $today = Carbon::today();
        $showtime = Showtime::create([
            'movie_id' => $movie->movie_id,
            'room_id' => $room->room_id,
            'date' => $today->toDateString(),
            'start_time' => '19:30:00',
            'end_time' => '21:50:00',
            'status' => 'active'
        ]);

        // 8. Showtime_seats (tất cả ghế đều available)
        foreach ($seats as $seat) {
            ShowtimeSeat::create([
                'showtime_id' => $showtime->showtime_id,
                'seat_id' => $seat->seat_id,
                'status' => 'available'
            ]);
        }

        $this->command->info('✔ Demo phim Avatar đã được tạo thành công.');
    }
}
