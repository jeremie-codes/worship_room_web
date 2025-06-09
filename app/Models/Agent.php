<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Agent extends Model
{
    protected $fillable = [
        'matricule',
        'nom',
        'prenom',
        'date_naissance',
        'lieu_naissance',
        'sexe',
        'adresse',
        'telephone',
        'email',
        'date_engagement',
        'status',
        'service_id',
        'observations'
    ];

    protected $casts = [
        'date_naissance' => 'date',
        'date_engagement' => 'date',
    ];

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function isActif(): bool
    {
        return $this->status === 'actif';
    }

    public function getNomCompletAttribute(): string
    {
        return "{$this->nom} {$this->prenom}";
    }

    public function getAncienneteAttribute(): int
    {
        return $this->date_engagement->diffInYears(now());
    }
}
