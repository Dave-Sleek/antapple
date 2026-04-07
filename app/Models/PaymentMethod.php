<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    protected $fillable = [
        'user_id',
        'provider',
        'authorization_code',
        'card_type',
        'last4',
        'exp_month',
        'exp_year',
        'is_default'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
