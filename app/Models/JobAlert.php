<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobAlert extends Model
{
    protected $fillable = [
        'email',
        'category_id',
        'location',
        'remote_only',
        'frequency',
        'is_active',
        'unsubscribe_token',
        'last_sent_at'
    ];

    protected $casts = [
        'remote_only' => 'boolean',
        'is_active' => 'boolean',
        'last_sent_at' => 'datetime',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
