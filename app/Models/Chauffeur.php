<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Chauffeur extends Model
{
    protected $fillable = [
        'matricule',
        'nom',
        'prenom',
        'telephone',
        'numero_permis',
        'date_expiration_permis',
        'status',
        'observations'
    ];

    protected $casts = [
        'date_expiration_permis' => 'date',
    ];

    public function missions(): HasMany
    {
        return $this->hasMany(MissionVehicule::class);
    }

    public function getNomCompletAttribute(): string
    {
        return "{$this->nom} {$this->prenom}";
    }

    public function estDisponible(): bool
    {
        return $this->status === 'disponible' && 
            !$this->missions()
                ->whereIn('status', ['en_attente', 'approuve', 'en_cours'])
                ->exists();
    }

    public function permisEstValide(): bool
    {
        return $this->date_expiration_permis->isFuture();
    }
}