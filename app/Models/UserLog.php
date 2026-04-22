<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserLog extends Model
{
    protected $fillable = [
        'user_id',
        'ip_address',
        'user_agent',
        'endpoint',
        'method',
        'location'
    ];

}
