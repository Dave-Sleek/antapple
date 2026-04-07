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

    // public function isAttack()
    // {
    //     return str_contains($this->endpoint, '.env') ||
    //         str_contains($this->endpoint, 'wp-admin') ||
    //         str_contains($this->endpoint, 'phpmyadmin') ||
    //         str_contains($this->endpoint, 'vendor') ||
    //         str_contains($this->endpoint, 'storage');
    // }
}
