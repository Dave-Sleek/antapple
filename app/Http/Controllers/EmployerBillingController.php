<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;



class EmployerBillingController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $subscription = Subscription::with('plan')
            ->where('user_id', $user->id)
            ->where('status', 'active')
            ->latest()
            ->first();

        $payments = Payment::where('user_id', $user->id)
            ->where('status', 'successful')
            ->latest()
            ->paginate(10);

        $methods = PaymentMethod::where('user_id', $user->id)
            ->latest()
            ->get();

        return view('employer.billing.index', compact(
            'subscription',
            'payments',
            'methods'
        ));
    }

    public function downloadInvoice(Payment $payment)
    {
        // This replaces your private function check
        $this->authorize('view', $payment);

        $pdf = Pdf::loadView('employer.billing.invoice', [
            'payment' => $payment
        ]);

        return $pdf->download('invoice-' . $payment->id . '.pdf');
    }

    public function cancelSubscription()
    {
        $subscription = Subscription::where('user_id', Auth::id())
            ->where('status', 'active')
            ->first();

        if (!$subscription) {
            return back()->with('error', 'No active subscription found.');
        }

        $subscription->update([
            'status' => 'cancelled',
            'ends_at' => now()
        ]);

        return back()->with('success', 'Subscription cancelled successfully.');
    }

    public function verify($reference)
    {
        $response = Http::withToken(config('services.paystack.secret_key'))
            ->get("https://api.paystack.co/transaction/verify/$reference");


        /** @var \Illuminate\Http\Client\Response $response */
        $data = $response->json();

        if (!$data['status'] || $data['data']['status'] !== 'success') {
            return redirect()->route('billing')
                ->with('error', 'Payment failed.');
        }

        $user = Auth::user();

        // ✅ ADD IT HERE (RIGHT AFTER SUCCESS CHECK)
        $authorization = $data['data']['authorization'];

        PaymentMethod::updateOrCreate(
            [
                'user_id' => $user->id,
                'authorization_code' => $authorization['authorization_code']
            ],
            [
                'provider' => 'paystack',
                'card_type' => $authorization['card_type'],
                'last4' => $authorization['last4'],
                'exp_month' => $authorization['exp_month'],
                'exp_year' => $authorization['exp_year'],
                'is_default' => true,
            ]
        );

        return redirect()->route('billing')
            ->with('success', 'Subscription activated successfully!');
    }

    private function authorizePayment($payment)
    {
        if ($payment->user_id !== Auth::id()) {
            abort(403);
        }
    }
}
