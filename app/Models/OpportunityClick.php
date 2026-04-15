<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OpportunityClick extends Model
{
    protected $fillable = [
        'opportunity_id',
        'user_id',
        'ip_address',
        'session_id'
    ];
}
