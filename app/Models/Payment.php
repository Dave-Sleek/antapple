<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

class Payment extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'subscription_id',
        'reference',
        'provider',
        'amount',
        'currency',
        'status',
        'payload',
        'paid_at',
    ];

    protected $casts = [
        'amount'   => 'decimal:2',
        'payload'  => 'array',
        'paid_at'  => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Query Scopes (Very Important for Admin Dashboard)
    |--------------------------------------------------------------------------
    */

    public function scopeSuccessful(Builder $query)
    {
        return $query->where('status', 'successful');
    }

    public function scopePending(Builder $query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeFailed(Builder $query)
    {
        return $query->where('status', 'failed');
    }

    public function scopeThisMonth(Builder $query)
    {
        return $query->whereMonth('paid_at', now()->month)
            ->whereYear('paid_at', now()->year);
    }

    /*
    |--------------------------------------------------------------------------
    | Business Logic Methods
    |--------------------------------------------------------------------------
    */

    public function markAsSuccessful(array $payload = [])
    {
        $this->update([
            'status'  => 'successful',
            'payload' => $payload ?: $this->payload,
            'paid_at' => now(),
        ]);
    }

    public function markAsFailed(array $payload = [])
    {
        $this->update([
            'status'  => 'failed',
            'payload' => $payload ?: $this->payload,
        ]);
    }

    public function markAsRefunded()
    {
        $this->update([
            'status' => 'refunded',
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Revenue Helpers
    |--------------------------------------------------------------------------
    */

    public static function totalRevenue()
    {
        return static::successful()->sum('amount');
    }

    public static function monthlyRevenue()
    {
        return static::successful()
            ->thisMonth()
            ->sum('amount');
    }
}
