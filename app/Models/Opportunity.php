<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Opportunity extends Model
{
    protected $fillable = [
        'uuid',
        'user_id',
        'title',
        'slug',
        'type',
        'organization',
        'description',
        'location',
        'is_remote',
        'salary_range',
        'funding_type',
        'deadline',
        'apply_url',
        'image',
        'is_active',
        'is_verified',
        'is_featured',
        'featured_until',
    ];

    protected $casts = [
        'is_remote' => 'boolean',
        'is_active' => 'boolean',
        'is_verified' => 'boolean',
        'is_featured' => 'boolean',
        'deadline' => 'date',
        'featured_until' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | AUTO UUID & SLUG
    |--------------------------------------------------------------------------
    */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($opportunity) {
            $opportunity->uuid = (string) Str::uuid();
            $opportunity->slug = Str::slug($opportunity->title);
        });

        static::updating(function ($opportunity) {
            $opportunity->slug = Str::slug($opportunity->title);
        });
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */

    // Optional: who created it (admin or employer)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES (VERY IMPORTANT FOR CLEAN QUERIES)
    |--------------------------------------------------------------------------
    */

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true)
            ->where('featured_until', '>', now());
    }

    public function scopeType($query, $type)
    {
        return $query->where('type', $type);
    }

    /*
    |--------------------------------------------------------------------------
    | HELPERS (SMART UI LOGIC)
    |--------------------------------------------------------------------------
    */

    public function isExpired()
    {
        return $this->deadline && $this->deadline->isPast();
    }

    public function isCurrentlyFeatured()
    {
        return $this->is_featured && $this->featured_until && $this->featured_until->isFuture();
    }

    public function typeLabel()
    {
        return ucfirst(str_replace('_', ' ', $this->type));
    }

    public function getRouteKeyName()
    {
        return 'uuid';
    }
}