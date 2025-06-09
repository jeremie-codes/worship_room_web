<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Cotation extends Model
{
    protected $fillable = [
        'agent_id',
        'user_id',
        'annee',
        'note_competence',
        'note_performance',
        'note_comportement',
        'note_finale',
        'observations',
        'status',
        'commentaire_validateur'
    ];

    protected $casts = [
        'annee' => 'integer',
        'note_competence' => 'integer',
        'note_performance' => 'integer',
        'note_comportement' => 'integer',
        'note_finale' => 'integer',
    ];

    public function agent(): BelongsTo
    {
        return $this->belongsTo(User::class, 'agent_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function calculerNoteFinal(): int
    {
        return round(($this->note_competence + $this->note_performance + $this->note_comportement) / 3);
    }

    public function getMention(): string
    {
        if ($this->note_finale >= 18) return 'Excellent';
        if ($this->note_finale >= 16) return 'Très Bien';
        if ($this->note_finale >= 14) return 'Bien';
        if ($this->note_finale >= 12) return 'Assez Bien';
        if ($this->note_finale >= 10) return 'Passable';
        return 'Insuffisant';
    }
}
