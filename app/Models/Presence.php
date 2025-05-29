<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Presence extends Model
{
    protected $fillable = [
        'employe_id',
        'date',
        'status',
        'heure_arrivee',
        'heure_depart',
        'commentaire',
    ];

    protected $casts = [
        'date' => 'date',
        'heure_arrivee' => 'datetime',
        'heure_depart' => 'datetime',
    ];

    public function employe()
    {
        return $this->belongsTo(Employe::class);
    }
}