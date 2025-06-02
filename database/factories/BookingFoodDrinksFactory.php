<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class BookingFoodDrinksFactory extends Factory
{
    public function definition(): array
    {
        return [
            'booking_id' => $this->faker->randomNumber(),
            'item_id' => $this->faker->randomNumber(),
            'quantity' => $this->faker->numberBetween(1, 5),
            'price' => $this->faker->randomFloat(2, 5, 100),
        ];
    }
}
