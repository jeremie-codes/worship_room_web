<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Demande extends Model
{
    protected $fillable = [
        'user_id',
        'produit_id',
        'service_id',
        'quantite',
        'commentaire',
        'urgence',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function produit()
    {
        return $this->belongsTo(Produit::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}