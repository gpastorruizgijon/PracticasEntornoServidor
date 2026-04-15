<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'password',
        'address',
        'phone',
        'license_type'
    ];

    protected $hidden = ['password', 'remember_token'];

    // Relación: Un conductor puede haber manejado muchos camiones
    public function trucks(): HasMany
    {
        return $this->hasMany(Truck::class);
    }

    // Un usuario puede tener muchas ofertas
    public function offers()
    {
        return $this->hasMany(Offer::class);
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isConductor(): bool
    {
        return $this->role === 'conductor';
    }
}
