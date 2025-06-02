<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class BookingQrcodesFactory extends Factory
{
    public function definition(): array
    {
        return [
            'booking_id' => $this->faker->randomNumber(),, 'qr_code' => $this->faker->randomNumber(),, 'qr_type' => $this->faker->randomNumber(),, 'created_at' => $this->faker->randomNumber(),, 'expired_at' => $this->faker->randomNumber(),, 'is_printed' => $this->faker->randomNumber(),, 'printed_at' => $this->faker->randomNumber(),, 'printed_by' => $this->faker->randomNumber(),
        ];
    }
}
