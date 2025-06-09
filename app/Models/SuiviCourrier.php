<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SuiviCourrier extends Model
{
    protected $table = 'suivi_courriers';

    protected $fillable = [
        'courrier_id',
        'user_id',
        'action',
        'commentaire',
        'donnees_avant',
        'donnees_apres'
    ];

    protected $casts = [
        'donnees_avant' => 'array',
        'donnees_apres' => 'array',
    ];

    public function courrier(): BelongsTo
    {
        return $this->belongsTo(Courrier::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getActionLibelleAttribute(): string
    {
        return match($this->action) {
            'creation' => 'Création',
            'reception' => 'Réception',
            'transmission' => 'Transmission',
            'traitement' => 'Traitement',
            'reponse' => 'Réponse',
            'archivage' => 'Archivage',
            'modification' => 'Modification',
            'cloture' => 'Clôture',
            default => ucfirst($this->action)
        };
    }
}