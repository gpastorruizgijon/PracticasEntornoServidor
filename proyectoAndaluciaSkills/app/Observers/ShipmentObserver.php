<?php

namespace App\Observers;

use App\Models\Shipment;
use Illuminate\Support\Facades\Log;

class ShipmentObserver
{
    public function created(Shipment $shipment): void
    {
        if ($shipment->status === 'Entregado') {
            $planta = $shipment->plant;
            
            $totalOcupado = $planta->shipments()->sum('kilos_transported');

            if ($totalOcupado > $planta->max_capacity_kg) {
                Log::warning("La planta {$planta->name} ha superado su capacidad máxima.");
            }
        }
    }
}