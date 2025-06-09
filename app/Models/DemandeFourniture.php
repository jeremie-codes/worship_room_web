<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DemandeFourniture extends Model
{
    protected $fillable = [
        'service_id',
        'user_id',
        'article_id',
        'quantite',
        'niveau_urgence',
        'motif',
        'status',
        'commentaire_validateur',
        'date_livraison'
    ];

    protected $casts = [
        'date_livraison' => 'datetime',
    ];

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class);
    }

    public function estLivrable(): bool
    {
        return $this->status === 'approuve' && $this->article->quantite >= $this->quantite;
    }
}