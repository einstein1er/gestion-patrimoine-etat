<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Bien extends Model
{
    protected $fillable = [
        'categorie_id',
        'nom',
        'code',
        'description',
        'valeur',
        'date_acquisition',
        'etat',
        'localisation',
        'actif',
    ];

    protected $casts = [
        'valeur' => 'decimal:2',
        'date_acquisition' => 'date',
        'actif' => 'boolean',
    ];

    public function categorie(): BelongsTo
    {
        return $this->belongsTo(Categorie::class);
    }
}
