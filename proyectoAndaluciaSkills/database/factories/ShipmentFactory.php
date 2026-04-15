<?php

namespace Database\Factories;

use App\Models\Waste;
use App\Models\Truck;
use App\Models\RecyclingPlant;
use Illuminate\Database\Eloquent\Factories\Factory;

class ShipmentFactory extends Factory
{
    public function definition(): array
{
    $truck = \App\Models\Truck::inRandomOrder()->first() ?? \App\Models\Truck::factory()->create();
    $pickup = fake()->dateTimeBetween('-1 month', 'now');

    return [
        'waste_id' => \App\Models\Waste::inRandomOrder()->first()?->id ?? \App\Models\Waste::factory(),
        'truck_id' => $truck->id,
        'recycling_plant_id' => \App\Models\RecyclingPlant::inRandomOrder()->first()?->id ?? \App\Models\RecyclingPlant::factory(),
        'kilos_transported' => fake()->numberBetween(100, $truck->max_load_kg), 
        'pickup_date' => $pickup,
        'delivery_date' => fake()->dateTimeBetween($pickup, '+2 days'),
        'status' => fake()->randomElement(['pending', 'in_transit', 'delivered']),
    ];
}
}
