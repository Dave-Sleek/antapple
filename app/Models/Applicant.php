<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Applicant extends Model
{
    protected $fillable = [
        'job_post_id',
        'name',
        'email',
        'resume',
        'cover_letter',
    ];

    public function job()
    {
        return $this->belongsTo(Job_post::class, 'job_post_id');
    }
}
