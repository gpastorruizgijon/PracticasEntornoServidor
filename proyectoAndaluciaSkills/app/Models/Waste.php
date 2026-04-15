<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Waste extends Model
{
    use HasFactory;
    use SoftDeletes;

    const TYPES = ['Plástico', 'Vidrio', 'Papel', 'Metal', 'Madera', 'Orgánico', 'Electrónico'];

    protected $fillable = ['type', 'kilos', 'origin_address', 'is_hazardous', 'user_id', 'shipment_id'];

    public function conductor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id')->withTrashed();
    }

    public function shipment(): BelongsTo
    {
        return $this->belongsTo(Shipment::class);
    }
}
