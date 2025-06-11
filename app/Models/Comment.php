<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'stream_id',
        'video_id',
        'content',
        'is_highlighted',
    ];

    protected $casts = [
        'is_highlighted' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function stream()
    {
        return $this->belongsTo(Stream::class);
    }

    public function video()
    {
        return $this->belongsTo(Video::class);
    }

    public function scopeHighlighted($query)
    {
        return $query->where('is_highlighted', true);
    }

    public function scopeForStream($query, $streamId)
    {
        return $query->where('stream_id', $streamId);
    }

    public function scopeForVideo($query, $videoId)
    {
        return $query->where('video_id', $videoId);
    }
}