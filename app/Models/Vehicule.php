<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Vehicule extends Model
{
    protected $fillable = [
        'immatriculation',
        'marque',
        'modele',
        'annee',
        'etat',
        'observations'
    ];

    public function missions(): HasMany
    {
        return $this->hasMany(MissionVehicule::class);
    }

    public function estDisponible(): bool
    {
        return $this->etat === 'bon_etat' && 
            !$this->missions()
                ->whereIn('status', ['en_attente', 'approuve', 'en_cours'])
                ->exists();
    }
}