<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Waste extends Model
{
    use SoftDeletes;

    protected $fillable = ['type', 'kilos', 'origin_address', 'is_hazardous'];

    // Relación: Una "bolsa/carga" de basura pertenece a un envío específico
    public function shipment(): HasOne
    {
        return $this->hasOne(Shipment::class);
    }
}