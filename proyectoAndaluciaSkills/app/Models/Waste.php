<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory; 

class Waste extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['type', 'kilos', 'origin_address', 'is_hazardous', 'user_id'];

    // Relación: Una "bolsa/carga" de basura pertenece a un envío específico
    public function shipment(): HasOne
    {
        return $this->hasOne(Shipment::class);
    }
}