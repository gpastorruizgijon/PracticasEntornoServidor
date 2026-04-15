<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; 
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Truck extends Model
{
    use SoftDeletes, HasFactory;

    protected $fillable = ['plate', 'model', 'max_load_kg', 'user_id'];

    public function driver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id')->withTrashed();
    }

    public function shipments(): HasMany
    {
        return $this->hasMany(Shipment::class);
    }
}