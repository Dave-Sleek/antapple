<?php

namespace App\Services\Payments;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Response;
use App\Models\User;
use App\Models\Plan;
use Exception;

class PaystackService
{
    /**
     * Initialize Paystack transaction for subscription.
     */
    public function initializePayment(User $user, Plan $plan, string $reference): string
    {
        try {
            /** @var Response $response */
            $response = Http::withToken(config('services.paystack.secret_key'))
                ->post('https://api.paystack.co/transaction/initialize', [
                    'email' => $user->email,
                    'amount' => $plan->price * 100, // Convert to kobo
                    'reference' => $reference,
                    'callback_url' => route('subscription.callback'),
                    'metadata' => [
                        'user_id' => $user->id,
                        'plan_id' => $plan->id,
                    ]
                ]);

            if ($response->failed() || !$response->json('status')) {
                throw new Exception('Paystack initialization failed.');
            }

            // return $response->json('data.authorization_url');
            // If you are in a Controller
            return redirect($response['data']['authorization_url']);
        } catch (Exception $e) {
            throw new Exception('Payment initialization error: ' . $e->getMessage());
        }
    }

    /**
     * Verify transaction reference.
     */
    public function verifyPayment(string $reference): array
    {
        /** @var Response $response */
        $response = Http::withToken(config('services.paystack.secret_key'))
            ->get("https://api.paystack.co/transaction/verify/{$reference}");

        // 1. Check for connection/HTTP errors (4xx, 5xx)
        if ($response->failed()) {
            throw new \Exception('Paystack connection error: ' . $response->reason());
        }

        // 2. Access the JSON data safely
        $data = $response->json();

        // 3. Check Paystack's internal 'status' boolean
        if (!isset($data['status']) || $data['status'] !== true) {
            throw new \Exception('Paystack verification failed: ' . ($data['message'] ?? 'Unknown error'));
        }

        return $data['data'];
    }
}
