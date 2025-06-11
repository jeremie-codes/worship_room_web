<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    use HasFactory;

    const STATUS_PENDING = 'pending';
    const STATUS_COMPLETED = 'completed';
    const STATUS_FAILED = 'failed';
    const STATUS_REFUNDED = 'refunded';

    const PAYMENT_METHOD_CARD = 'card';
    const PAYMENT_METHOD_MOBILE_MONEY = 'mobile_money';

    protected $fillable = [
        'donor_id',
        'broadcaster_id',
        'stream_id',
        'amount',
        'currency',
        'payment_method',
        'payment_reference',
        'status',
        'message',
        'is_anonymous',
        'processed_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'is_anonymous' => 'boolean',
        'processed_at' => 'datetime',
    ];

    public function donor()
    {
        return $this->belongsTo(User::class, 'donor_id');
    }

    public function broadcaster()
    {
        return $this->belongsTo(User::class, 'broadcaster_id');
    }

    public function stream()
    {
        return $this->belongsTo(Stream::class);
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', self::STATUS_COMPLETED);
    }

    public function scopeForBroadcaster($query, $broadcasterId)
    {
        return $query->where('broadcaster_id', $broadcasterId);
    }

    public function getFormattedAmountAttribute()
    {
        return number_format($this->amount, 2) . ' ' . strtoupper($this->currency);
    }
}