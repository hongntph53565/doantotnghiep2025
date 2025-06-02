<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class BookingsFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => $this->faker->randomNumber(),
            'showtime_id' => $this->faker->randomNumber(),
            'seat_id' => $this->faker->randomNumber(),
            'booking_status' => $this->faker->randomElement(['Pending', 'Confirmed', 'Cancelled']),
            'payment_status' => $this->faker->randomElement(['Pending', 'Paid', 'Refunded']),
            'created_at' => now(),
            'total_amount' => $this->faker->randomFloat(2, 50, 500),
            'booking_code' => 'BK' . $this->faker->unique()->numerify('######'),
            'booking_source' => $this->faker->randomElement(['web', 'counter']),
            'created_by' => $this->faker->randomNumber(),
        ];
    }
}
