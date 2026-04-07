<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Job_post;
use App\Models\User;
use App\Models\Applicant;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function dashboard()
    {
        $pendingJobs = Job_post::where('status', 'pending')->latest()->get();
        $totalJobs = Job_post::count();
        $TotalpendingJobs = Job_post::where('status', 'pending')->count();
        $approvedJobs = Job_post::where('status', 'active')->count();
        $rejectedJobs = Job_post::where('status', 'rejected')->count();

        $totalEmployers = User::where('role', 'employer')->count();
        $TotalFeaturedJobs = Job_post::where('is_featured', true)->count();
        $totalApplicants = Applicant::count();

        $totalRevenue = Payment::where('status', 'successful')->sum('amount');

        $uniqueViewers = \App\Models\JobView::distinct('ip')->count('ip');
        $totalViews = \App\Models\JobView::count();
        $topJobs = Job_post::withCount('jobViews')
            ->orderByDesc('job_views_count')
            ->take(5)
            ->get();

        $recentJobs = Job_post::latest()->take(5)->get();

        // 📈 Monthly Revenue (Last 6 Months)
        $monthlyRevenue = Payment::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('SUM(amount) as total')
        )
            ->where('status', 'successful')
            ->where('created_at', '>=', Carbon::now()->subMonths(6))
            ->groupBy('month')
            ->pluck('total', 'month');

        // 📊 Monthly Jobs Posted (Last 6 Months)
        $monthlyJobs = Job_post::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('COUNT(*) as total')
        )
            ->where('created_at', '>=', Carbon::now()->subMonths(6))
            ->groupBy('month')
            ->pluck('total', 'month');


        return view('admin.dashboard', compact(
            'totalJobs',
            'pendingJobs',
            'approvedJobs',
            'rejectedJobs',
            'totalEmployers',
            'totalApplicants',
            'totalRevenue',
            'TotalpendingJobs',
            'TotalFeaturedJobs',
            'recentJobs',
            'monthlyRevenue',
            'totalViews',
            'topJobs',
            'uniqueViewers',
            'monthlyJobs'
        ));
    }


    public function stats()
    {
        $approvedJobs = Job_post::where('status', 'active')->count();
        $pendingJobs = Job_post::where('status', 'pending')->count();
        $rejectedJobs = Job_post::where('status', 'rejected')->count();

        $totalRevenue = Payment::where('status', 'successful')->sum('amount');
        $totalEmployers = User::where('role', 'employer')->count();

        // Monthly Revenue (Last 6 Months)
        $monthlyRevenue = Payment::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('SUM(amount) as total')
        )
            ->where('status', 'successful')
            ->where('created_at', '>=', Carbon::now()->subMonths(6))
            ->groupBy('month')
            ->pluck('total', 'month');

        // Employer Growth
        $employerGrowth = User::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('COUNT(*) as total')
        )
            ->where('role', 'employer')
            ->where('created_at', '>=', Carbon::now()->subMonths(6))
            ->groupBy('month')
            ->pluck('total', 'month');

        return response()->json([
            'approvedJobs' => $approvedJobs,
            'pendingJobs' => $pendingJobs,
            'rejectedJobs' => $rejectedJobs,
            'totalRevenue' => $totalRevenue,
            'totalEmployers' => $totalEmployers,
            'monthlyRevenue' => $monthlyRevenue,
            'employerGrowth' => $employerGrowth
        ]);
    }

    public function approve(Job_post $job)
    {
        $job->update([
            'status' => 'active',
            'is_approved' => true
        ]);

        return back()->with('success', 'Job approved successfully.');
    }

    public function reject(Job_post $job)
    {
        $job->update([
            'status' => 'rejected',
            'is_approved' => false
        ]);

        return back()->with('success', 'Job rejected.');
    }
}
