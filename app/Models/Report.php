<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Report extends Model
{
    protected $fillable = [
        'job_post_id',
        'reason',
        'message',
    ];

    public function job()
    {
        return $this->belongsTo(Job_post::class, 'job_post_id');
    }

    public function jobPost()
    {
        return $this->belongsTo(Job_post::class, 'job_post_id', 'id');
    }

}
