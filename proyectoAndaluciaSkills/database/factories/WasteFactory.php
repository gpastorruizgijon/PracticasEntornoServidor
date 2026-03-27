<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Waste>
 */
class WasteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
{
    return [
        // Esto busca un conductor aleatorio para asignarle el residuo
        'user_id' => \App\Models\User::where('role', 'conductor')->inRandomOrder()->first()?->id ?? \App\Models\User::factory(),
        'type' => $this->faker->randomElement(['Plástico', 'Vidrio', 'Papel', 'Metal']),
        'kilos' => $this->faker->numberBetween(10, 1000),
        'origin_address' => $this->faker->address(),
        'is_hazardous' => $this->faker->boolean(20),
    ];
}
}

