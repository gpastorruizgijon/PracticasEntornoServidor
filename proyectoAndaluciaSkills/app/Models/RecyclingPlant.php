<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RecyclingPlant extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'address', 'city', 'max_capacity_kg'];

    // Relación: Una planta recibe muchos envíos
    public function shipments(): HasMany
    {
        return $this->hasMany(Shipment::class);
    }
}