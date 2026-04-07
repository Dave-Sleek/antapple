<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JobClick extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'job_post_id',
        'ip_address',
        'user_agent',
        'clicked_at',
    ];

    protected $dates = ['clicked_at'];

    public function job_posts(): BelongsTo
    {
        return $this->belongsTo(Job_post::class);
    }
}
