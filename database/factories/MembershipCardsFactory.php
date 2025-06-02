<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class MembershipCardsFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => $this->faker->randomNumber(),, 'card_type' => $this->faker->randomNumber(),, 'points' => $this->faker->randomNumber(),, 'issue_date' => $this->faker->randomNumber(),, 'expiry_date' => $this->faker->randomNumber(),
        ];
    }
}
