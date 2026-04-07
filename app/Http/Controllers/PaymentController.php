<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Job_post;
use Illuminate\Http\Client\Response; // Important for IDE recognition
use Exception;

class PaymentController extends Controller
{
    /**
     * Initialize the Paystack transaction.
     */
    public function initialize(Job_post $job)
    {
        try {
            /** @var Response $response */
            $response = Http::withToken(config('services.paystack.secret_key'))
                ->acceptJson()
                ->post(config('services.paystack.payment_url') . '/transaction/initialize', [
                    'email'        => request('email'),
                    'amount'       => 15000 * 100, // ₦15,000 in kobo
                    'callback_url' => route('payment.callback'),
                    'metadata'     => [
                        'job_id' => $job->id,
                    ],
                ]);

            // Check if the request itself failed (4xx or 5xx)
            if ($response->failed()) {
                return back()->with('error', 'Paystack Gateway Error: ' . $response->reason());
            }

            $responseData = $response->json();

            // Paystack returns a 'status' boolean in their JSON body
            if (isset($responseData['status']) && $responseData['status'] === true) {
                return redirect($responseData['data']['authorization_url']);
            }
        } catch (Exception $e) {
            return back()->with('error', 'Could not connect to payment processor: ' . $e->getMessage());
        }

        return back()->with('error', 'Payment initialization failed.');
    }

    /**
     * Handle the Paystack callback.
     */
    public function callback()
    {
        $reference = request('reference');

        if (!$reference) {
            return redirect('/')->with('error', 'No payment reference provided.');
        }

        try {
            /** @var Response $response */
            $response = Http::withToken(config('services.paystack.secret_key'))
                ->get(config('services.paystack.payment_url') . "/transaction/verify/{$reference}");

            $responseData = $response->json();

            if ($response->successful() && ($responseData['data']['status'] === 'success')) {

                // Safely extract job_id from metadata
                $jobId = $responseData['data']['metadata']['job_id'] ?? null;
                $job   = Job_post::find($jobId);

                if ($job) {
                    $job->update([
                        'is_paid'           => true,
                        'paid_at'           => now(),
                        'payment_reference' => $reference,
                        'status'            => 'active',
                        'is_approved'       => true,
                    ]);

                    return redirect('/')
                        ->with('success', 'Your job has been published successfully!');
                }
            }
        } catch (Exception $e) {
            return redirect('/')->with('error', 'Verification failed: ' . $e->getMessage());
        }

        return redirect('/')
            ->with('error', 'Payment verification failed.');
    }
}
