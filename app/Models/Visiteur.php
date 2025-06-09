<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Visiteur extends Model
{
    protected $fillable = [
        'nom',
        'prenom',
        'type',
        'entreprise',
        'telephone',
        'email',
        'piece_identite',
        'numero_piece',
        'motif',
        'service_id',
        'destination',
        'heure_arrivee',
        'heure_depart',
        'observations',
        'status',
        'user_id',
        'badge_numero',
        'vehicule',
        'immatriculation_vehicule',
        'accompagnants'
    ];

    protected $casts = [
        'heure_arrivee' => 'datetime',
        'heure_depart' => 'datetime',
        'vehicule' => 'boolean',
        'accompagnants' => 'array',
    ];

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getNomCompletAttribute(): string
    {
        return trim($this->nom . ' ' . $this->prenom);
    }

    public function getDureeVisiteAttribute(): ?string
    {
        if (!$this->heure_depart) {
            return null;
        }

        $duree = $this->heure_arrivee->diff($this->heure_depart);
        
        if ($duree->h > 0) {
            return $duree->h . 'h ' . $duree->i . 'min';
        }
        
        return $duree->i . 'min';
    }

    public function estEnVisite(): bool
    {
        return $this->status === 'en_visite' && !$this->heure_depart;
    }

    public function marquerSortie(): void
    {
        $this->update([
            'heure_depart' => now(),
            'status' => 'parti'
        ]);
    }

    public static function genererNumeroBadge(): string
    {
        $numero = static::whereDate('created_at', today())->count() + 1;
        return 'V' . date('Ymd') . sprintf('%03d', $numero);
    }

    public function getNombreAccompagnantsAttribute(): int
    {
        return is_array($this->accompagnants) ? count($this->accompagnants) : 0;
    }
}