<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Maintenance extends Model
{
    protected $fillable = [
        'bien_id',
        'type',
        'date_maintenance',
        'cout',
        'description',
        'prestataire',
        'statut',
        'actif',
    ];

    protected $casts = [
        'date_maintenance' => 'date',
        'cout' => 'decimal:2',
        'actif' => 'boolean',
    ];

    public function bien(): BelongsTo
    {
        return $this->belongsTo(Bien::class);
    }
}
