<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Truck extends Model
{
    use SoftDeletes;

    protected $fillable = ['plate', 'model', 'max_load_kg', 'user_id'];

    // Relación: El camión pertenece a un conductor
    public function driver(): BelongsTo
    {
        // withTrashed() permite que si el conductor es "borrado", el camión aún muestre quién era
        return $this->belongsTo(User::class, 'user_id')->withTrashed();
    }

    public function shipments(): HasMany
    {
        return $this->hasMany(Shipment::class);
    }
}