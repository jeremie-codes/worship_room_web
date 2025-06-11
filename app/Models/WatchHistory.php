<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WatchHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'stream_id',
        'video_id',
        'watched_duration',
        'last_position',
    ];

    protected $casts = [
        'watched_duration' => 'integer',
        'last_position' => 'integer',
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
}