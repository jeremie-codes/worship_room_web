<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'matricule',
        'name',
        'email',
        'password',
        'date_naissance',
        'lieu_naissance',
        'sexe',
        'adresse',
        'telephone',
        'date_engagement',
        'status',
        'service_id',
        'observations'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'date_naissance' => 'date',
            'date_engagement' => 'date',
        ];
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function presences(): HasMany
    {
        return $this->hasMany(Presence::class);
    }

    public function conges(): HasMany
    {
        return $this->hasMany(Conge::class, 'agent_id');
    }

    public function missions(): HasMany
    {
        return $this->hasMany(Mission::class, 'agent_id');
    }

    public function cotations(): HasMany
    {
        return $this->hasMany(Cotation::class, 'agent_id');
    }

    public function paiements(): HasMany
    {
        return $this->hasMany(Paiement::class, 'agent_id');
    }

    public function visiteurs(): HasMany
    {
        return $this->hasMany(Visiteur::class);
    }

    public function courriers(): HasMany
    {
        return $this->hasMany(Courrier::class);
    }

    public function isActif(): bool
    {
        return $this->status === 'actif';
    }

    public function getNomCompletAttribute(): string
    {
        return $this->name;
    }

    public function getAncienneteAttribute(): int
    {
        return $this->date_engagement ? $this->date_engagement->diffInYears(now()) : 0;
    }

}
