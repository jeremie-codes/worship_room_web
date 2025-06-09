<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Conge extends Model
{
    protected $fillable = [
        'agent_id',
        'user_id',
        'date_debut',
        'date_fin',
        'duree',
        'motif',
        'status',
        'commentaire_directeur',
        'commentaire_rh',
        'commentaire_drh'
    ];

    protected $casts = [
        'date_debut' => 'date',
        'date_fin' => 'date',
    ];

    public function agent(): BelongsTo
    {
        return $this->belongsTo(User::class, 'agent_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function calculDroitsConges(): int
    {
        $anciennete = $this->agent->anciennete;
        $joursBase = 30; // 1 mois de congé = 30 jours
        $joursSupplementaires = min($anciennete, 3); // Maximum 3 jours supplémentaires

        return $joursBase + $joursSupplementaires;
    }

    public function estEligible(): bool
    {
        return $this->agent->anciennete >= 1;
    }
}
