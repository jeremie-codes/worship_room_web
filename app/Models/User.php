<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    const ROLE_SPECTATOR = 'spectator';
    const ROLE_BROADCASTER = 'broadcaster';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'role',
        'avatar',
        'bio',
        'website_url',
        'is_active',
        'account_deactivated_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'account_deactivated_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function streams()
    {
        return $this->hasMany(Stream::class, 'broadcaster_id');
    }

    public function videos()
    {
        return $this->hasMany(Video::class, 'broadcaster_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function donations()
    {
        return $this->hasMany(Donation::class, 'donor_id');
    }

    public function receivedDonations()
    {
        return $this->hasMany(Donation::class, 'broadcaster_id');
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class, 'subscriber_id');
    }

    public function subscribers()
    {
        return $this->hasMany(Subscription::class, 'broadcaster_id');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function watchHistory()
    {
        return $this->hasMany(WatchHistory::class);
    }

    public function isBroadcaster()
    {
        return $this->role === self::ROLE_BROADCASTER;
    }

    public function isSpectator()
    {
        return $this->role === self::ROLE_SPECTATOR;
    }

    public function getTotalDonationsAttribute()
    {
        return $this->receivedDonations()->sum('amount');
    }

    public function getSubscribersCountAttribute()
    {
        return $this->subscribers()->count();
    }
}