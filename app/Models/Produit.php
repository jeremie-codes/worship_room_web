<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produit extends Model
{
    protected $fillable = [
        'nom',
        'reference',
        'categorie_id',
        'quantite',
        'seuil_alerte',
        'prix_unitaire',
        'description',
    ];

    public function categorie()
    {
        return $this->belongsTo(Categorie::class);
    }

    public function demandes()
    {
        return $this->hasMany(Demande::class);
    }
}