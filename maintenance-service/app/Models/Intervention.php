<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Intervention extends Model
{
    protected $fillable = [
        'bien_id',
        'technicien_id',
        'type',
        'description',
        'date_intervention',
        'statut',
        'cout',
    ];

    protected $casts = [
        'date_intervention' => 'datetime',
        'cout' => 'decimal:2',
    ];
}
