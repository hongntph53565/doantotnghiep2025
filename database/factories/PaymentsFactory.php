<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PaymentsFactory extends Factory
{
    public function definition(): array
    {
        return [
            'booking_id' => $this->faker->randomNumber(),, 'payment_method' => $this->faker->randomNumber(),, 'amount' => $this->faker->randomNumber(),, 'payment_date' => $this->faker->randomNumber(),
        ];
    }
}
