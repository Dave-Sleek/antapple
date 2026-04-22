<?php

namespace App\Http\Controllers;

use App\Models\Job_post;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Models\JobAlert;
use App\Mail\JobAlertMail;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class EmployerController extends Controller
{

    public function dashboard(Request $request)
    {
        $userId = auth::id();

        $query = Job_post::where('user_id', $userId)
            ->withCount('jobViews');


        // 🔎 Search by title
        if ($request->search) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // 📌 Filter by status
        if ($request->status) {
            $query->where('status', $request->status);
        }

        // 📌 Filter by type
        if ($request->type) {
            if ($request->type === 'featured') {
                $query->where('is_featured', true);
            } elseif ($request->type === 'standard') {
                $query->where('is_featured', false);
            }
        }

        // 📅 Date range filter
        if ($request->from && $request->to) {
            $query->whereBetween('created_at', [$request->from, $request->to]);
        }

        $jobs = $query->latest()->paginate(10);

        $totalJobs = Job_post::where('user_id', $userId)->count();

        $approvedJobs = Job_post::where('user_id', $userId)
            ->where('status', 'approved')
            ->count();

        $totalRevenue = Payment::where('user_id', $userId)
            ->where('status', 'successful')
            ->sum('amount');


        $totalViews = \App\Models\JobView::whereHas('job', function ($q) {
            $q->where('user_id', auth::id());
        })->count();

        $subscription = auth::user()->subscription;

        $plan = $subscription?->plan;

        $featuredUsed = auth::user()->jobs()
            ->where('is_featured', true)
            ->count();

        $featuredLimit = $plan->featured_limit ?? 0;

        return view('employer.dashboard', compact(
            'jobs',
            'totalJobs',
            'approvedJobs',
            'totalRevenue',
            'featuredUsed',
            'totalViews',
            'featuredLimit'
        ));
    }


    public function exportJobs()
    {
        $jobs = Job_post::where('user_id', auth::id())->get();

        $filename = "my_jobs.csv";

        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
        ];

        $callback = function () use ($jobs) {

            $file = fopen('php://output', 'w');
            fputcsv($file, ['Title', 'Status', 'Type', 'Date']);

            foreach ($jobs as $job) {
                fputcsv($file, [
                    $job->title,
                    $job->status,
                    $job->is_featured ? 'Featured' : 'Standard',
                    $job->created_at
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }


    public function companyPage(User $user)
    {
        // Only show employers
        if ($user->role !== 'employer') abort(404);

        // Jobs posted by this employer
        $jobs = $user->jobs()->where('status', 'active')->latest()->get();

        return view('employer.company_page', compact('user', 'jobs'));
    }


    // Show Create Form
    public function create()
    {

        $user = auth::user();

        if ($user->profileCompletion() < 80) { // Require 80% filled
            return redirect()->route('employer.profile')
                ->with('error', 'Please complete your profile before posting a job.');
        }

         if (auth::user()->hasReachedJobLimit()) {
        return redirect()->route('employer.dashboard')
            ->with('error', 'Limit reached.');
            }

            return view('employer.create');


        $categories = Category::all();
        return view('employer.create', compact('categories'));
    }


    // Store Job
    public function store(Request $request)
    {
        $user = Auth::user();

            if (!$user) {
                return redirect()->route('login');
            }

        $data = $request->validate([
            'title'             => 'required|string|max:255',
            'company_name'      => 'required|string|max:255',
            'is_verified'       => 'nullable|boolean',
            'about_company'     => 'nullable|string|max:2000',
            'company_logo'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'category_id'       => 'required|exists:categories,id',
            'job_type'          => 'required|string',
            'location'          => 'required|string',
            'is_remote'         => 'nullable|boolean',
            'apply_url'         => 'required|url|max:2048',
            'short_description' => 'required|string',
            'deadline'          => 'nullable|date',
            'experience_level'  => 'nullable|string|max:255',
            'salary_range'      => 'nullable|string|max:255',
        ]);


        // If remote, override location
        if ($request->boolean('is_remote')) {
            $data['location'] = 'Remote';
        }


        if ($request->hasFile('company_logo')) {
            $path = $request->file('company_logo')->store('logos', 'public');
            $data['company_logo'] = $path; // e.g. "logos/filename.png"
        }


        $data['uuid'] = (string) Str::uuid();
        $data['user_id'] = $user->id;
        $data['source'] = 'employer';
        $data['is_verified'] = true; // default to not verified
        /*
    |--------------------------------------------------------------------------
    | SMART SUBSCRIPTION LOGIC
    |--------------------------------------------------------------------------
    */
        if ($user->hasActiveSubscription()) {
            // Subscriber → auto approved
            $data['status'] = 'active';
            $data['is_paid'] = true;
            $data['is_approved'] = true;
            // $data['is_featured'] = true;

            $successMessage = 'Job posted successfully and is now live.';
        } else {
            // No subscription → pending review
            $data['status'] = 'pending';
            $data['is_paid'] = false;
            $data['is_approved'] = false;

            $successMessage = 'Job created successfully. Awaiting admin approval.';
        }

        $job = Job_post::create($data);

        // Flush sitemap cache to reflect new job
        Cache::flush();

        // Ping Google to update sitemap
        Http::get('https://www.google.com/ping', [
            'sitemap' => url('/sitemap.xml')
        ]);

        /*
        | Email alerts (queue)
        */
        $alerts = JobAlert::where('is_active', true)->get();

        foreach ($alerts as $alert) {
            Mail::to($alert->email)
                ->queue(new JobAlertMail(collect([$job]), $alert));
        }


        /*
        | Telegram notify
        */
        if ($job->status === 'active' && config('services.telegram.bot_token')) {

            $message = "🚀 *New Job Posted*\n\n"
                . "*{$job->title}*\n"
                . "🏢 {$job->company_name}\n"
                . "📍 {$job->location}\n"
                . "💼 {$job->job_type}\n"
                . "Apply here: "
                . "🔗 " . route('jobs.show', ['job' => $job->uuid, 'slug' => Str::slug($job->title)]);

            Http::post(
                "https://api.telegram.org/bot" . config('services.telegram.bot_token') . "/sendMessage",
                [
                    'chat_id' => config('services.telegram.chat_id'),
                    'text' => $message,
                    'parse_mode' => 'Markdown'
                ]
            );
        }

        return redirect()->route('employer.dashboard')
            ->with('success', $successMessage);
    }

    // Feature Job
    public function feature(Job_post $job)
    {
        // Ensure job belongs to logged-in employer
        if ($job->user_id !== Auth::id()) {
            abort(403);
        }

        // Get active subscription
        $subscription = Auth::user()->subscription;

        if (!$subscription || $subscription->status !== 'active') {
            return back()->with('error', 'You need an active subscription to feature jobs.');
        }

        $plan = $subscription->plan;

        // Check if plan allows featuring
        if ($plan->featured_limit <= 0) {
            return back()->with('error', 'Your plan does not allow featured jobs.');
        }

        // Count active featured jobs
        $featuredUsed = Job_post::where('user_id', Auth::id())
            ->where('is_featured', true)
            ->count();

        if ($featuredUsed >= $plan->featured_limit) {
            return back()->with('error', 'You have reached your featured job limit.');
        }

        // Feature the job
        $job->update([
            'is_featured' => true,
            'featured_until' => now()->addDays($plan->feature_duration),
        ]);

        return back()->with('success', 'Job marked as featured successfully.');
    }

    public function unfeature(Job_post $job)
    {
        if ($job->user_id !== Auth::id()) {
            abort(403);
        }

        $job->update([
            'is_featured' => false,
            'featured_until' => null,
        ]);

        return back()->with('success', 'Job unfeatured successfully.');
    }

    // Edit Job
    public function edit(Job_post $job)
    {
        if ($job->user_id !== Auth::id()) {
            abort(403);
        }

        $subscription = Auth::user()->subscription;

        if ($job->is_featured && (!$subscription || $subscription->status !== 'successful')) {
            return back()->with('error', 'You cannot edit a featured job without an active subscription.');
        }

        $categories = Category::all();
        return view('employer.edit', compact('job', 'categories'));
    }

    // Update Job
    public function update(Request $request, Job_post $job)
    {
        if ($job->user_id !== Auth::id()) {
            abort(403);
        }

        $subscription = Auth::user()->subscrption;
        if ($job->is_featured && (!$subscription || $subscription->status !== 'successful')) {
            return back()->with('error', 'You cannot update a featured job without an active subscription.');
        }

        $job->update($request->all());

        return redirect()->route('employer.dashboard')
            ->with('success', 'Job updated successfully.');
    }


    public function profile()
    {
        $user = auth::user();
        return view('employer.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = auth::user();

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id, // ignore current user
            'company_name' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'website' => 'nullable|url',
            'location' => 'nullable|string|max:255',
            'about_company' => 'nullable|string|max:2000',
            'linkedin' => 'nullable|url',
            'twitter' => 'nullable|url',
            'company_logo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'password' => 'nullable|min:6|confirmed',
        ]);

        if ($request->hasFile('company_logo')) {
            $data['company_logo'] = $request->file('company_logo')
                ->store('company_logos', 'public');
        }

        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $data['profile_completed'] = true;

        $user->update($data);

        return back()->with('success', 'Profile updated successfully.');
    }


    public function applicants(Job_post $job)
    {
        if ($job->user_id !== Auth::id()) {
            abort(403);
        }

        $applicants = $job->applicants()->latest()->get();

        return view('employer.applicants', compact('job', 'applicants'));
    }


    public function trash()
    {
        $jobs = Job_post::onlyTrashed()
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);
        // $totalJobs = $jobs->total();


        return view('employer.jobs.trash', compact('jobs'));
    }

    public function restore($id)
    {
        $job = Job_post::onlyTrashed()
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        $job->restore();

        return back()->with('success', 'Job restored successfully.');
    }


    public function forceDelete($id)
    {
        $job = Job_post::onlyTrashed()
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        $job->forceDelete();

        return back()->with('success', 'Job permanently deleted.');
    }


    // Delete Job
    public function destroy(Job_post $job)
    {
        if ($job->user_id !== Auth::id()) {
            abort(403);
        }

        $job = Job_post::where('user_id', auth::id())->findOrFail($job->id);

        $job->delete();

        return back()->with('success', 'Job moved to trash.');
    }
}
