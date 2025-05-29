<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employe extends Model
{
    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'telephone',
        'grade',
        'service',
        'fonction',
        'date_engagement',
    ];

    protected $casts = [
        'date_engagement' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function conges()
    {
        return $this->hasMany(Conge::class);
    }

    public function presences()
    {
        return $this->hasMany(Presence::class);
    }
}