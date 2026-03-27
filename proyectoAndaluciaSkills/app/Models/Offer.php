<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    protected $fillable = ['user_id', 'title', 'description', 'company', 'salary', 'is_active'];

// Relación inversa: Una oferta pertenece a un usuario
public function user()
{
    return $this->belongsTo(User::class);
}
}
