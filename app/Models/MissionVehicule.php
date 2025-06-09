<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MissionVehicule extends Model
{
    protected $table = 'missions_vehicules';

    protected $fillable = [
        'reference',
        'user_id',
        'chauffeur_id',
        'vehicule_id',
        'motif',
        'itineraire',
        'date_heure_depart',
        'date_heure_retour',
        'kilometrage_depart',
        'kilometrage_retour',
        'status',
        'observations'
    ];

    protected $casts = [
        'date_heure_depart' => 'datetime',
        'date_heure_retour' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function chauffeur(): BelongsTo
    {
        return $this->belongsTo(Chauffeur::class);
    }

    public function vehicule(): BelongsTo
    {
        return $this->belongsTo(Vehicule::class);
    }

    public static function genererReference(): string
    {
        $prefix = 'MSV';
        $annee = date('Y');
        $numero = static::whereYear('created_at', $annee)->count() + 1;
        return sprintf('%s-%s-%04d', $prefix, $annee, $numero);
    }

    public function estTerminable(): bool
    {
        return in_array($this->status, ['approuve', 'en_cours']);
    }

    public function estAnnulable(): bool
    {
        return in_array($this->status, ['en_attente', 'approuve']);
    }
}