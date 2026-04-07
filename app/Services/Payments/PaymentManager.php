<?php

namespace App\Services\Payments;

use App\Models\User;
use App\Models\Plan;

class PaymentManager
{
    public function initialize(User $user, Plan $plan, string $reference)
    {
        return app(PaystackService::class)
            ->initializePayment($user, $plan, $reference);
    }
}
