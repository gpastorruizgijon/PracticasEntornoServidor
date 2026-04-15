<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Shipment extends Model
{
    use HasFactory;

    protected $fillable = [
        'truck_id', 'recycling_plant_id', 'type',
        'kilos_transported', 'pickup_date', 'delivery_date', 'status'
    ];

    protected $casts = [
        'pickup_date' => 'datetime',
        'delivery_date' => 'datetime',
    ];

    public function wastes(): HasMany
    {
        return $this->hasMany(Waste::class);
    }

    public function truck(): BelongsTo
    {
        return $this->belongsTo(Truck::class)->withTrashed();
    }

    public function plant(): BelongsTo
    {
        return $this->belongsTo(RecyclingPlant::class, 'recycling_plant_id')->withTrashed();
    }
}
