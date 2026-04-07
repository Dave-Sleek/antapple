<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobView extends Model
{
    protected $fillable = ['job_post_id', 'ip'];

    public function job()
    {
        return $this->belongsTo(Job_post::class, 'job_post_id');
    }
}
