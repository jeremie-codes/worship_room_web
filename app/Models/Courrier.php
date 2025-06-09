<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Courrier extends Model
{
    protected $fillable = [
        'reference',
        'type',
        'motif',
        'objet',
        'description',
        'expediteur',
        'destinataire',
        'service_expediteur_id',
        'service_destinataire_id',
        'date_courrier',
        'date_reception',
        'date_envoi',
        'date_limite_reponse',
        'priorite',
        'status',
        'user_id',
        'user_responsable_id',
        'repertoire',
        'numero_chrono',
        'confidentiel',
        'observations',
        'historique_traitement'
    ];

    protected $casts = [
        'date_courrier' => 'date',
        'date_reception' => 'date',
        'date_envoi' => 'date',
        'date_limite_reponse' => 'date',
        'confidentiel' => 'boolean',
        'historique_traitement' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function agentResponsable(): BelongsTo
    {
        return $this->belongsTo(Agent::class, 'user_responsable_id');
    }

    public function serviceExpediteur(): BelongsTo
    {
        return $this->belongsTo(Service::class, 'service_expediteur_id');
    }

    public function serviceDestinataire(): BelongsTo
    {
        return $this->belongsTo(Service::class, 'service_destinataire_id');
    }

    public function documents(): HasMany
    {
        return $this->hasMany(DocumentCourrier::class);
    }

    public function suivis(): HasMany
    {
        return $this->hasMany(SuiviCourrier::class);
    }

    public static function genererReference(string $type): string
    {
        $prefix = match($type) {
            'entrant' => 'CE',
            'sortant' => 'CS',
            'interne' => 'CI',
            default => 'C'
        };

        $annee = date('Y');
        $numero = static::whereYear('created_at', $annee)
            ->where('type', $type)
            ->count() + 1;

        return sprintf('%s-%s-%04d', $prefix, $annee, $numero);
    }

    public function estEnRetard(): bool
    {
        return $this->date_limite_reponse &&
               $this->date_limite_reponse->isPast() &&
               !in_array($this->status, ['traite', 'clos', 'archive']);
    }

    public function getDelaiTraitementAttribute(): ?int
    {
        if (!$this->date_reception || $this->status === 'en_attente') {
            return null;
        }

        $dateDebut = $this->date_reception;
        $dateFin = $this->status === 'traite' ? $this->updated_at : now();

        return $dateDebut->diffInDays($dateFin);
    }

    public function ajouterSuivi(string $action, string $commentaire = null, array $donneesAvant = null, array $donneesApres = null): void
    {
        $this->suivis()->create([
            'user_id' => auth()->id(),
            'action' => $action,
            'commentaire' => $commentaire,
            'donnees_avant' => $donneesAvant,
            'donnees_apres' => $donneesApres,
        ]);
    }

    public function changerStatus(string $nouveauStatus, string $commentaire = null): void
    {
        $ancienStatus = $this->status;

        $this->update(['status' => $nouveauStatus]);

        $this->ajouterSuivi(
            'modification',
            $commentaire ?? "Changement de statut: $ancienStatus → $nouveauStatus",
            ['status' => $ancienStatus],
            ['status' => $nouveauStatus]
        );
    }
}
