<?php

namespace App\Http\Controllers;

use App\Models\Job_post;
use App\Models\JobClick;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\JobView;

class JobController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | JOB LIST PAGE (Paginated)
    |--------------------------------------------------------------------------
    */
    public function index(Request $request)
    {

        if (Auth::check() && !Auth::user()->is_active) {
                return redirect()->route('account.suspended');
            }

        $categories = Category::withCount([
            'jobs' => fn($q) => $q->where('status', 'active')
        ])->orderBy('name')->get();

        $jobs = Job_post::active()

            // 🔍 Keyword search
            ->when($request->keyword, function ($q) use ($request) {
                $q->where(function ($qq) use ($request) {
                    $qq->where('title', 'like', "%{$request->keyword}%")
                        ->orWhere('company_name', 'like', "%{$request->keyword}%")
                        ->orWhere('short_description', 'like', "%{$request->keyword}%");
                });
            })

            // 📂 Category
            ->when(
                $request->category,
                fn($q) =>
                $q->where('category_id', $request->category)
            )

            // 📍 Location + Remote smart filter
            ->when($request->location, function ($q) use ($request) {
                if ($request->remote) {
                    $q->where(function ($qq) use ($request) {
                        $qq->where('location', 'like', "%{$request->location}%")
                            ->orWhere('is_remote', true);
                    });
                } else {
                    $q->where('location', 'like', "%{$request->location}%");
                }
            })

            // 🌍 Remote only
            ->when(
                $request->remote && !$request->location,
                fn($q) =>
                $q->where('is_remote', true)
            )

            // 💼 Job type
            ->when(
                $request->job_type,
                fn($q) =>
                $q->where('job_type', $request->job_type)
            )

            ->orderByDesc('is_featured')
            ->latest()
            ->paginate(12) // 🔥 better UX
            ->withQueryString();


        $fallbackJobs = collect();

        if ($jobs->isEmpty() && $request->hasAny(['keyword', 'category', 'location', 'remote', 'job_type'])) {
            $fallbackJobs = Job_post::active()
                ->latest()
                ->limit(4)
                ->get();
        }

        // ======================================
        // People Also Searched suggestions
        // ======================================

        // top categories by job count
        $popularCategories = Category::withCount([
            'jobs' => fn($q) => $q->where('status', 'active')
        ])
            ->orderByDesc('jobs_count')
            ->limit(5)
            ->get();

        // common job types
        $jobTypes = Job_post::select('job_type')
            ->distinct()
            ->pluck('job_type')
            ->take(4);

        $peopleAlsoSearched = collect();

        // add categories
        foreach ($popularCategories as $cat) {
            $peopleAlsoSearched->push([
                'label' => $cat->name,
                'url'   => route('jobs.index', ['category' => $cat->id])
            ]);
        }

        // add job types
        foreach ($jobTypes as $type) {
            $peopleAlsoSearched->push([
                'label' => ucfirst($type),
                'url'   => route('jobs.index', ['job_type' => $type])
            ]);
        }

        // add remote
        $peopleAlsoSearched->push([
            'label' => 'Remote Jobs',
            'url'   => route('jobs.index', ['remote' => 1])
        ]);


        // ======================================
        // HOT JOBS TODAY (most clicks today)
        // ======================================
        $today = Carbon::today();

        // get top clicked job IDs first
        $hotJobIds = DB::table('job_clicks')
            ->select('job_post_id', DB::raw('COUNT(*) as clicks'))
            ->whereDate('created_at', $today)
            ->groupBy('job_post_id')
            ->orderByDesc('clicks')
            ->limit(6)
            ->pluck('job_post_id');


        // fetch actual jobs
        $hotJobs = Job_post::active()
            ->whereIn('id', $hotJobIds)
            ->get()
            ->sortBy(function ($job) use ($hotJobIds) {
                return array_search($job->id, $hotJobIds->toArray());
            });

        $recommendedJobs = Job_post::active()
            ->inRandomOrder()
            ->limit(6)
            ->get();

        $interestedJobs = Job_post::active()
            ->latest()
            ->limit(6)
            ->get();

        $abujaJobs = Job_post::active()
            ->where('location', 'Abuja, Nigeria')
            ->limit(6)
            ->get();

        $lagosJobs = Job_post::active()
            ->where('location', 'Lagos, Nigeria')
            ->limit(6)
            ->get();

        $footerLocations = Job_post::active()
            ->select('location')
            ->distinct()
            ->limit(5)
            ->pluck('location');

        // Footer Code

        // Fallback to random if not enough hot jobs

        return view('jobs.index', compact('jobs', 'categories', 'peopleAlsoSearched', 'hotJobs', 'recommendedJobs', 'interestedJobs', 'abujaJobs', 'lagosJobs', 'footerLocations', 'fallbackJobs'));
    }

    /*
    |--------------------------------------------------------------------------
    | SHOW JOB (Paginated related sections)
    |--------------------------------------------------------------------------
    */
    public function show(Job_post $job, $slug)
    {
        abort_if($job->status !== 'active', 404);

        // Optional: redirect if slug is wrong (SEO protection)
        if ($job->slug !== $slug) {
            return redirect()->route('jobs.show', [
                'uuid' => $job->uuid,
                'slug' => $job->slug
            ], 301);
        }


        $exists = $job->jobViews()
            ->where('ip', request()->ip())
            ->whereDate('created_at', now())
            ->exists();

        if (!$exists) {
            $job->jobViews()->create([
                'ip' => request()->ip(),
            ]);
            // $job->increment('views');
        }
        $job->loadCount('jobViews');

        /*
        | Similar Jobs (paginate)
        */
        $similarJobs = Job_post::active()
            ->where('id', '!=', $job->id)
            ->where(function ($query) use ($job) {
                $query->where('category_id', $job->category_id)
                    ->orWhere('job_type', $job->job_type);
            })
            ->latest()
            ->paginate(6, ['*'], 'similar');


        /*
        | Same company jobs (paginate)
        */
        $companyJobs = Job_post::active()
            ->where('company_name', $job->company_name)
            ->where('id', '!=', $job->id)
            ->latest()
            ->paginate(4, ['*'], 'company');


        /*
        | Recently viewed
        */
        $recent = Session::get('recent_jobs', []);
        array_unshift($recent, $job->id);

        $recent = array_unique($recent);
        $recent = array_slice($recent, 0, 6);

        Session::put('recent_jobs', $recent);

        $recentJobs = Job_post::whereIn('id', $recent)
            ->where('id', '!=', $job->id)
            ->get();


        /*
        | Recommended (paginate)
        */
        $recommendedJobs = Job_post::active()
            ->where('id', '!=', $job->id)
            ->where('category_id', $job->category_id)
            ->inRandomOrder()
            ->paginate(6, ['*'], 'recommended');

        return view('jobs.show', compact(
            'job',
            'similarJobs',
            'companyJobs',
            'recentJobs',
            'exists',
            'recommendedJobs'
        ));
    }


    /*
    |--------------------------------------------------------------------------
    | APPLY REDIRECT
    |--------------------------------------------------------------------------
    */
    public function redirect(Job_post $job, Request $request)
    {
        JobClick::create([
            'job_post_id' => $job->id,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'clicked_at' => now(),
        ]);

        return redirect()->away($job->apply_url);
    }
}
