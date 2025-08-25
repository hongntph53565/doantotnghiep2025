<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\Booking;
use App\Models\Showtime;
use App\Models\User;

class BookingSeeder extends Seeder
{
      public function run()
    {
        $user = User::first(); 
        $showtime = Showtime::withTrashed()->inRandomOrder()->first();

        $paymentMethods = ['cash', 'vnpay', 'zalopay', 'payos'];

        foreach (range(1, 6) as $month) {
            // Lấy random ngày trong tháng trước
            $date = Carbon::now()->subMonths($month)->startOfMonth()->addDays(rand(0, 25));

            Booking::create([
                'user_id' => $user->user_id,
                'showtime_id' => $showtime->showtime_id,
                'booking_status' => 'confirmed',
                'payment_status' => 'paid',
                'payment_method' => $paymentMethods[array_rand($paymentMethods)],
                'booking_code' => strtoupper(uniqid("BK")),
                'total_price' => rand(80000, 300000),
                'created_at' => $date,
                'updated_at' => $date,
            ]);
        }
    }
}