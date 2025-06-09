<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Mission extends Model
{
    protected $fillable = [
        'reference',
        'agent_id',
        'user_id',
        'lieu',
        'objet',
        'date_debut',
        'date_fin',
        'duree',
        'frais_mission',
        'status',
        'observations',
        'rapport'
    ];

    protected $casts = [
        'date_debut' => 'date',
        'date_fin' => 'date',
        'frais_mission' => 'decimal:2',
    ];

    public function agent(): BelongsTo
    {
        return $this->belongsTo(User::class, 'agent_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public static function genererReference(): string
    {
        $prefix = 'MSN';
        $annee = date('Y');
        $numero = static::whereYear('created_at', $annee)->count() + 1;
        return sprintf('%s-%s-%04d', $prefix, $annee, $numero);
    }

    public function estTerminee(): bool
    {
        return $this->date_fin->isPast();
    }

    public function estEnCours(): bool
    {
        return now()->between($this->date_debut, $this->date_fin);
    }
}
