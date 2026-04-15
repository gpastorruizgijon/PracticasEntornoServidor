<?php

namespace Database\Factories;

use App\Models\Shipment;
use App\Models\Waste;
use App\Models\Truck;
use App\Models\RecyclingPlant;
use Illuminate\Database\Eloquent\Factories\Factory;

class ShipmentFactory extends Factory
{
    protected $model = Shipment::class;

    public function definition(): array
    {
        $tipo  = fake()->randomElement(\App\Models\Waste::TYPES);
        $truck = Truck::inRandomOrder()->first() ?? Truck::factory()->create();
        $pickup = fake()->dateTimeBetween('-1 month', 'now');

        return [
            'truck_id'           => $truck->id,
            'recycling_plant_id' => RecyclingPlant::inRandomOrder()->first()?->id
                                    ?? RecyclingPlant::factory(),
            'type'               => $tipo,
            'kilos_transported'  => 0, // se calcula en afterCreating
            'pickup_date'        => $pickup,
            'delivery_date'      => fake()->dateTimeBetween($pickup, '+2 days'),
            'status'             => fake()->randomElement(['pending', 'in_transit', 'delivered']),
        ];
    }

    public function configure(): static
    {
        return $this->afterCreating(function (Shipment $shipment) {
            // Coger residuos disponibles del mismo tipo (sin envío asignado)
            $wastes = Waste::where('type', $shipment->type)
                ->whereNull('shipment_id')
                ->whereNull('deleted_at')
                ->inRandomOrder()
                ->take(fake()->numberBetween(1, 3))
                ->get();

            // Si no hay suficientes disponibles, crearlos
            if ($wastes->isEmpty()) {
                $wastes = Waste::factory(fake()->numberBetween(1, 3))->create([
                    'type' => $shipment->type,
                ]);
            }

            // Vincular residuos y actualizar kilos
            Waste::whereIn('id', $wastes->pluck('id'))->update(['shipment_id' => $shipment->id]);
            $shipment->update(['kilos_transported' => $wastes->sum('kilos')]);
        });
    }
}
