<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Shipment extends Model
{
    // Nota: Los envíos normalmente no se borran (soft delete), 
    // se quedan como historial aunque la planta o el camión desaparezcan.

    protected $fillable = [
        'waste_id', 'truck_id', 'recycling_plant_id', 
        'kilos_transported', 'pickup_date', 'delivery_date', 'status'
    ];

    protected $casts = [
        'pickup_date' => 'datetime',
        'delivery_date' => 'datetime',
    ];

    public function waste(): BelongsTo {
        return $this->belongsTo(Waste::class)->withTrashed();
    }

    public function truck(): BelongsTo {
        return $this->belongsTo(Truck::class)->withTrashed();
    }

    public function plant(): BelongsTo {
        return $this->belongsTo(RecyclingPlant::class, 'recycling_plant_id')->withTrashed();
    }
}
