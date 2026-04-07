<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Subscriber extends Model
{
    protected $fillable = [
        'email',
        'preferred_category_id',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'preferred_category_id');
    }
}
