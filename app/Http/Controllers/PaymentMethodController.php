<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;
use Illuminate\Support\Facades\Auth;

class PaymentMethodController extends Controller
{
    public function index()
    {
        $methods = Auth::user()->paymentMethods;

        return view('employer.billing.methods', compact('methods'));
    }

    public function setDefault(PaymentMethod $method)
    {
        abort_if($method->user_id !== Auth::id(), 403);

        Auth::user()->paymentMethods()->update(['is_default' => false]);

        $method->update(['is_default' => true]);

        return back()->with('success', 'Default payment method updated.');
    }

    public function destroy(PaymentMethod $method)
    {
        abort_if($method->user_id !== Auth::id(), 403);

        $method->delete();

        return back()->with('success', 'Payment method removed.');
    }
}
