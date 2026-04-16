<?php

namespace App\Observers;

use App\Models\Shipment;
use Illuminate\Support\Facades\Log;

class ShipmentObserver
{
    public function updated(Shipment $shipment): void
    {
        if ($shipment->wasChanged('status') && $shipment->status === 'delivered') {
            $planta = $shipment->plant;
            if (!$planta) return;

            $totalActivo = $planta->shipments()
                ->whereIn('status', ['pending', 'in_transit'])
                ->sum('kilos_transported');

            if ($totalActivo > $planta->max_capacity_kg) {
                Log::warning("La planta {$planta->name} ha superado su capacidad máxima.", [
                    'plant_id'     => $planta->id,
                    'capacity'     => $planta->max_capacity_kg,
                    'current_load' => $totalActivo,
                ]);
            }
        }
    }
}
