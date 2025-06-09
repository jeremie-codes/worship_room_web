<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Article extends Model
{
    protected $fillable = [
        'nom',
        'code',
        'categorie',
        'quantite',
        'seuil_alerte',
        'description'
    ];

    public function demandes(): HasMany
    {
        return $this->hasMany(DemandeFourniture::class);
    }

    public function estEnRupture(): bool
    {
        return $this->quantite <= 0;
    }

    public function estEnAlerte(): bool
    {
        return $this->quantite <= $this->seuil_alerte;
    }
}