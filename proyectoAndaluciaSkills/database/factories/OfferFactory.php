<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Offer>
 */
class OfferFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
    'user_id' => \App\Models\User::factory(), // Crea un usuario si no hay uno
    'title' => $this->faker->jobTitle(),
    'description' => $this->faker->paragraph(),
    'company' => $this->faker->company(),
    'salary' => $this->faker->numberBetween(18000, 45000),
];
    }
}
