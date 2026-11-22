<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Affectation extends Model
{
    protected $fillable = [
        'bien_id',
        'utilisateur_id',
        'date_affectation',
        'date_fin',
        'observations',
    ];

    protected function casts(): array
    {
        return [
            'date_affectation' => 'date',
            'date_fin' => 'date',
        ];
    }

    public function bien()
    {
        return $this->belongsTo(Bien::class);
    }
}
