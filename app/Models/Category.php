<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $fillable = ['name', 'slug'];

    public function job_posts(): HasMany
    {
        return $this->hasMany(Job_post::class);
    }

    public function jobPosts()
    {
        return $this->hasMany(Job_post::class);
    }

    public function jobs(): HasMany
    {
        return $this->hasMany(Job_post::class, 'category_id');
    }
}
