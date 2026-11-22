<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Localisation extends Model
{
    protected $fillable = ['nom', 'adresse', 'ville'];

    public function biens()
    {
        return $this->hasMany(Bien::class);
    }
}
