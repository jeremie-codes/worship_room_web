<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stream extends Model
{
    use HasFactory;

    const STATUS_SCHEDULED = 'scheduled';
    const STATUS_LIVE = 'live';
    const STATUS_ENDED = 'ended';
    const STATUS_CANCELLED = 'cancelled';

    protected $fillable = [
        'broadcaster_id',
        'title',
        'description',
        'cover_image',
        'status',
        'scheduled_at',
        'started_at',
        'ended_at',
        'stream_key',
        'viewer_count',
        'max_viewers',
        'is_featured',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
        'started_at' => 'datetime',
        'ended_at' => 'datetime',
        'is_featured' => 'boolean',
        'viewer_count' => 'integer',
        'max_viewers' => 'integer',
    ];

    public function broadcaster()
    {
        return $this->belongsTo(User::class, 'broadcaster_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function donations()
    {
        return $this->hasMany(Donation::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function watchHistory()
    {
        return $this->hasMany(WatchHistory::class);
    }

    public function isLive()
    {
        return $this->status === self::STATUS_LIVE;
    }

    public function isScheduled()
    {
        return $this->status === self::STATUS_SCHEDULED;
    }

    public function isEnded()
    {
        return $this->status === self::STATUS_ENDED;
    }

    public function scopeLive($query)
    {
        return $query->where('status', self::STATUS_LIVE);
    }

    public function scopeScheduled($query)
    {
        return $query->where('status', self::STATUS_SCHEDULED);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }
}