<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Plan;
use App\Services\Subscriptions\SubscriptionService;
use Illuminate\Http\Request;

class WebhookController extends Controller
{
    public function handlePaystack(Request $request, SubscriptionService $subscriptionService)
    {
        $payload = $request->all();

        $reference = $payload['data']['reference'] ?? null;

        $payment = Payment::where('reference', $reference)->first();

        if (!$payment) {
            return response()->json(['message' => 'Payment not found'], 404);
        }

        if ($payload['data']['status'] === 'success') {

            $payment->markAsSuccessful($payload);

            $plan = Plan::where('price', $payment->amount)->first();

            $subscriptionService->activateSubscription(
                $payment->user,
                $plan,
                $payment
            );
        }

        return response()->json(['status' => 'ok']);
    }
}
