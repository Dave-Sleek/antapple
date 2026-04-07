<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Plan;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AdminPaymentController extends Controller
{
    public function index(Request $request)
    {
        $query = Payment::with(['user', 'subscription.plan'])
            ->where('status', 'successful');

        // 🔍 FILTER: Date Range
        if ($request->start_date && $request->end_date) {
            $query->whereBetween('created_at', [
                Carbon::parse($request->start_date)->startOfDay(),
                Carbon::parse($request->end_date)->endOfDay()
            ]);
        }

        // 🔍 FILTER: Plan
        if ($request->plan_id) {
            $query->whereHas('subscription.plan', function ($q) use ($request) {
                $q->where('id', $request->plan_id);
            });
        }

        // 🔍 FILTER: Employer
        if ($request->employer) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->employer . '%');
            });
        }

        $payments = $query->latest()->paginate(15);

        $totalRevenue = $query->sum('amount');

        $plans = Plan::all();

        // 📊 Revenue Per Plan
        $revenuePerPlan = Payment::with('subscription.plan')
            ->where('status', 'successful')
            ->get()
            ->groupBy(fn($payment) => optional($payment->subscription->plan)->name)
            ->map(fn($group) => $group->sum('amount'));

        // 📦 Total Subscriptions Per Plan
        $subscriptionsPerPlan = Payment::with('subscription.plan')
            ->where('status', 'successful')
            ->get()
            ->groupBy(fn($payment) => optional($payment->subscription->plan)->name)
            ->map(fn($group) => $group->count());

        // 📈 Revenue Growth (Month-over-Month)
        $currentMonthRevenue = Payment::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->where('status', 'successful')
            ->sum('amount');

        $lastMonthRevenue = Payment::whereMonth('created_at', now()->subMonth()->month)
            ->whereYear('created_at', now()->subMonth()->year)
            ->where('status', 'successful')
            ->sum('amount');

        $growth = $lastMonthRevenue > 0
            ? (($currentMonthRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100
            : 0;

        return view('admin.revenue.payments', compact(
            'payments',
            'totalRevenue',
            'plans',
            'revenuePerPlan',
            'subscriptionsPerPlan',
            'growth'
        ));
    }

    // Chart

    public function chart()
    {
        $data = Payment::where('status', 'successful')
            ->selectRaw('MONTH(created_at) as month, SUM(amount) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        return response()->json([
            'labels' => $data->pluck('month'),
            'values' => $data->pluck('total')
        ]);
    }

    // 📁 CSV EXPORT
    public function export()
    {
        $payments = Payment::with(['user', 'subscription.plan'])
            ->where('status', 'successful')
            ->get();

        $response = new StreamedResponse(function () use ($payments) {
            $handle = fopen('php://output', 'w');

            fputcsv($handle, [
                'Employer',
                'Email',
                'Plan',
                'Amount',
                'Status',
                'Date',
                'Reference'
            ]);

            foreach ($payments as $payment) {
                fputcsv($handle, [
                    $payment->user->name ?? '',
                    $payment->user->email ?? '',
                    optional(optional($payment->subscription)->plan)->name ?? '',
                    $payment->amount,
                    $payment->status,
                    $payment->created_at,
                    $payment->payment_reference
                ]);
            }

            fclose($handle);
        });

        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename="payments.csv"');

        return $response;
    }
}
