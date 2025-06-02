<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class FoodDrinksFactory extends Factory
{
    public function definition(): array
    {
        return [
            'item_name' => $this->faker->randomNumber(),, 'price' => $this->faker->randomNumber(),, 'combo_type' => $this->faker->randomNumber(),, 'status' => $this->faker->randomNumber(),
        ];
    }
}
