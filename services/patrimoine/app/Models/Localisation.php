<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Localisation extends Model
{
    protected $fillable = [
        'nom',
        'code',
        'type',
        'parent_id',
        'actif',
    ];

    protected $casts = [
        'actif' => 'boolean',
    ];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Localisation::class, 'parent_id');
    }

    public function enfants(): HasMany
    {
        return $this->hasMany(Localisation::class, 'parent_id');
    }
}
