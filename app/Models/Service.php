<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Service extends Model
{
    protected $fillable = [
        'nom',
        'code',
        'description',
        'responsable_id',
        'service_parent_id'
    ];

    public function responsable(): BelongsTo
    {
        return $this->belongsTo(User::class, 'agent_responsable_id');
    }

    public function serviceParent(): BelongsTo
    {
        return $this->belongsTo(Service::class, 'service_parent_id');
    }

    public function sousServices(): HasMany
    {
        return $this->hasMany(Service::class, 'service_parent_id');
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function visiteurs(): HasMany
    {
        return $this->hasMany(Visiteur::class);
    }
}
