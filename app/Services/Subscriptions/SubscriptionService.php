<?php

namespace App\Services\Subscriptions;

use App\Models\User;
use App\Models\Plan;
use App\Models\Payment;
use App\Services\Payments\PaymentManager;
use App\Notifications\PaymentAlertNotification;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class SubscriptionService
{
    public function initiateSubscription(User $user, Plan $plan)
    {
        $reference = 'SUB_' . Str::uuid();

        Payment::create([
            'user_id'  => $user->id,
            'reference' => $reference,
            'provider' => 'paystack',
            'amount'   => $plan->price,
            'currency' => 'NGN',
            'status'   => 'pending',
        ]);

        return app(PaymentManager::class)
            ->initialize($user, $plan, $reference);
    }

    public function activateSubscription(User $user, Plan $plan, Payment $payment, bool $isRenewal = false)
    {
        return DB::transaction(function () use ($user, $plan, $payment, $isRenewal) {
            // Determine subscription start date
            $startsAt = $isRenewal
                ? \Carbon\Carbon::parse($user->subscription->ends_at)->addDays(1)
                : now();

            // Calculate expiry based on billing cycle
            $endsAt = match ($plan->billing_cycle) {
                'monthly' => $startsAt->copy()->addMonth(),
                'yearly'  => $startsAt->copy()->addYear(),
                default   => $startsAt->copy()->addMonth(),
            };

            // Create or update subscription
            $subscription = $user->subscription()->updateOrCreate(
                ['user_id' => $user->id],
                [
                    'plan_id'                  => $plan->id,
                    'provider'                 => $payment->provider,
                    'provider_subscription_id' => $payment->reference,
                    'status'                   => 'active',
                    'starts_at'                => $startsAt,
                    'ends_at'                  => $endsAt,
                    'trial_ends_at'            => null,
                    'cancelled_at'             => null,
                ]
            );

            // Link payment to subscription
            $payment->update([
                'subscription_id' => $subscription->id,
                'status'          => 'successful',
                'paid_at'         => now(),
            ]);

            // Notify user of successful payment
            $user->notify(new PaymentAlertNotification($payment));

            // Notify admin of the payment
            $admin = User::where('role', 'admin')->first();
            if ($admin) {
                $admin->notify(new PaymentAlertNotification($payment));
            }


            // Mark user as subscribed
            $user->update(['is_subscribed' => true]);

            return $subscription;
        });
    }

    public function changePlan(User $user, Plan $newPlan)
    {
        $subscription = $user->subscription;

        if (!$subscription || !$subscription->isActive()) {
            throw new \Exception('No active subscription.');
        }

        $startsAt = now();

        $endsAt = match ($newPlan->billing_cycle) {
            'monthly' => $startsAt->copy()->addMonth(),
            'yearly'  => $startsAt->copy()->addYear(),
            default   => $startsAt->copy()->addMonth(),
        };

        $subscription->update([
            'plan_id' => $newPlan->id,
            'starts_at' => $startsAt,
            'ends_at' => $endsAt,
        ]);

        return $subscription;
    }
}
