<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Showtime;

class BookingFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::inRandomOrder()->first()?->user_id ?? User::factory(),
            'showtime_id' => Showtime::inRandomOrder()->first()?->showtime_id ?? Showtime::factory(),
            'booking_status' => $this->faker->randomElement(['pending', 'confirmed', 'cancelled']),
            'payment_status' => $this->faker->randomElement(['unpaid', 'paid']),
            'payment_method' => $this->faker->randomElement(['cash', 'payos', 'momo']),
            'booking_code' => strtoupper(Str::random(8)),
            'total_price' => $this->faker->numberBetween(50000, 500000),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
