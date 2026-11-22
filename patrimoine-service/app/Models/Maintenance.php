<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Maintenance extends Model
{
    protected $fillable = [
        'bien_id',
        'type',
        'date_maintenance',
        'description',
        'cout',
        'statut',
    ];

    protected function casts(): array
    {
        return [
            'date_maintenance' => 'date',
            'cout' => 'decimal:2',
        ];
    }

    public function bien()
    {
        return $this->belongsTo(Bien::class);
    }
}
