<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\Payment;
use App\Services\Subscriptions\SubscriptionService;
use App\Services\Payments\PaystackService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function index()
    {
        $subscription = Auth::user()->subscription;
        return view('employer.subscription.index', compact('subscription'));
    }

    public function pricing()
    {
        $plans = Plan::where('is_active', true)->get();
        return view('employer.pricing', compact('plans'));
    }

    public function subscribe(Plan $plan, SubscriptionService $subscriptionService)
    {
        return $subscriptionService->initiateSubscription(Auth::user(), $plan);
    }

    /*
    |--------------------------------------------------------------------------
    | RENEW SUBSCRIPTION
    |--------------------------------------------------------------------------
    */

    public function renew(SubscriptionService $subscriptionService)
    {
        $user = auth::user();
        $subscription = $user->subscription;

        if (!$subscription || $subscription->status !== 'active') {
            return redirect()->back()->with('error', 'No active subscription to renew.');
        }

        // Check if within 5-day grace period after expiry
        $graceEnd = \Carbon\Carbon::parse($subscription->ends_at)->addDays(5);
        if (now()->greaterThan($graceEnd)) {
            return redirect()->back()->with('error', 'Renewal period has expired. Please choose a new plan.');
        }

        $plan = $subscription->plan;

        // Initiate renewal payment
        return $subscriptionService->initiateSubscription($user, $plan);
    }

    /*
    |--------------------------------------------------------------------------
    | PAYSTACK CALLBACK
    |--------------------------------------------------------------------------
    */



    public function webhook(Request $request, SubscriptionService $subscriptionService)
    {
        $payload = $request->all();

        // Optional: Verify Paystack signature here for security

        $signature = $request->header('x-paystack-signature');
        $computedSignature = hash_hmac('sha512', $request->getContent(), config('services.paystack.secret_key'));

        if ($signature !== $computedSignature) {
            return response()->json(['status' => 'invalid signature'], 403);
        }

        if (($payload['event'] ?? null) === 'charge.success') {

            $reference = $payload['data']['reference'] ?? null;

            if (!$reference) {
                return response()->json(['status' => 'invalid reference'], 400);
            }

            $payment = Payment::where('reference', $reference)->first();

            if (!$payment) {
                return response()->json(['status' => 'not found'], 404);
            }

            $user = $payment->user;
            $plan = $user->subscription?->plan;

            if (!$plan) {
                return response()->json(['status' => 'plan missing'], 400);
            }

            $subscriptionService->activateSubscription($user, $plan, $payment);
        }

        return response()->json(['status' => 'success']);
    }

    public function callback(
        PaystackService $paystack,
        SubscriptionService $subscriptionService
    ) {
        $reference = request('reference');

        if (!$reference) {
            return redirect()->route('pricing')
                ->with('error', 'No payment reference provided.');
        }

        try {
            $payment = Payment::where('reference', $reference)->first();

            if (!$payment) {
                return redirect()->route('pricing')
                    ->with('error', 'Payment record not found.');
            }

            $verification = $paystack->verifyPayment($reference);

            if ($verification['status'] !== 'success') {
                return redirect()->route('pricing')
                    ->with('error', 'Payment not successful.');
            }

            $planId = $verification['metadata']['plan_id'] ?? null;
            $plan   = Plan::find($planId);

            if (!$plan) {
                return redirect()->route('pricing')
                    ->with('error', 'Invalid plan data.');
            }

            $subscription = $subscriptionService->activateSubscription(
                $payment->user,
                $plan,
                $payment
            );

            // Store full payment payload
            $payment->update([
                'provider' => 'paystack',
                'amount'   => $verification['amount'] / 100,
                'currency' => $verification['currency'] ?? 'NGN',
                'payload'  => json_encode($verification),
            ]);

            return redirect()->route('employer.dashboard')
                ->with('success', 'Subscription activated successfully!');
        } catch (\Exception $e) {
            return redirect()->route('pricing')
                ->with('error', 'Payment verification failed.');
        }
    }
}
