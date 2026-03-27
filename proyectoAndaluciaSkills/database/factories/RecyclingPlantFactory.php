<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RecyclingPlant>
 */
class RecyclingPlantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
   public function definition(): array
{
    return [
        'name' => 'Planta ' . fake()->city(),
        'address' => fake()->address(),
        'city' => fake()->city(),
        'max_capacity_kg' => fake()->numberBetween(10000, 100000),
    ];
}
}
