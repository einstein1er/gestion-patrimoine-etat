<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bien extends Model
{
    protected $fillable = [
        'nom',
        'description',
        'valeur',
        'date_acquisition',
        'etat',
        'categorie_id',
        'localisation_id',
        'utilisateur_id',
    ];

    protected function casts(): array
    {
        return [
            'valeur' => 'decimal:2',
            'date_acquisition' => 'date',
        ];
    }

    public function categorie()
    {
        return $this->belongsTo(Categorie::class);
    }

    public function localisation()
    {
        return $this->belongsTo(Localisation::class);
    }

    public function affectations()
    {
        return $this->hasMany(Affectation::class);
    }

    public function maintenances()
    {
        return $this->hasMany(Maintenance::class);
    }
}
