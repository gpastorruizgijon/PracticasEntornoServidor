<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TruckFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::where('role', 'conductor')->inRandomOrder()->first()?->id ?? User::factory(['role' => 'conductor']),
            'plate' => fake()->bothify('####-??'), 
            'model' => fake()->randomElement(['Volvo FH16', 'Mercedes Actros', 'Scania R500', 'Iveco Stralis']),
            'max_load_kg' => fake()->numberBetween(3500, 25000),
        ];
    }
}
