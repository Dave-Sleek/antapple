<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminPlanController extends Controller
{
    public function index()
    {
        $plans = Plan::withCount('subscriptions')->latest()->get();

        foreach ($plans as $plan) {
            $plan->revenue = \App\Models\Payment::whereHas('subscription', function ($q) use ($plan) {
                $q->where('plan_id', $plan->id);
            })->sum('amount');
        }

        $totalSubscribers = \App\Models\Subscription::count();

        $monthlyRevenue = \App\Models\Payment::whereMonth('created_at', now()->month)
            ->sum('amount');

        return view('admin.plans.index', compact(
            'plans',
            'totalSubscribers',
            'monthlyRevenue'
        ));
    }

    public function store(Request $request)
    {
        Plan::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'price' => $request->price,
            'billing_cycle' => $request->billing_cycle,
            'job_limit' => $request->job_limit,
            'featured_limit' => $request->featured_limit,
            'can_view_applicants' => $request->has('can_view_applicants'),
            'is_active' => $request->has('is_active'),
            'description' => $request->description,
            // 'can_view_applicants' => $request->can_view_applicants ?? false,
            // 'is_active' => true,
        ]);

        return back()->with('success', 'Plan created');
    }

    public function update(Request $request, Plan $plan)
    {
        $plan->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'price' => $request->price,
            'billing_cycle' => $request->billing_cycle,
            'job_limit' => $request->job_limit,
            'featured_limit' => $request->featured_limit,
            'can_view_applicants' => $request->has('can_view_applicants'),
            'is_active' => $request->has('is_active'),
            'description' => $request->description,
        ]);

        return back()->with('success', 'Plan updated');
    }

    public function destroy(Plan $plan)
    {
        $plan->delete();
        return back()->with('success', 'Plan deleted');
    }
}
