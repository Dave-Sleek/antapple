<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Plan extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'price',
        'billing_cycle',
        'job_limit',
        'featured_limit',
        'feature_duration',
        'can_view_applicants',
        'is_active',
        'description'
    ];

    protected $casts = [
        'can_view_applicants' => 'boolean',
        'is_active' => 'boolean',
        'featured_limit' => 'integer',
        'feature_duration' => 'integer',
    ];


    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }
}
