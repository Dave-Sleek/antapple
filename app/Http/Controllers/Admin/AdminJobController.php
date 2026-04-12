<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Job_post;
use App\Models\Category;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\JobAlert;
use App\Mail\JobAlertMail;
use App\Mail\OpportunityAlertMail;
use App\Models\Opportunity;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class AdminJobController extends Controller
{
    public function index(Request $request)
    {
        $query = Job_post::withCount('jobViews'); // Start with the view count

        // 🔎 Search
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                    ->orWhere('company_name', 'like', '%' . $request->search . '%');
            });
        }

        // 📌 Status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // ⭐ Type (featured / standard)
        if ($request->filled('type')) {
            if ($request->type === 'featured') {
                $query->where('is_featured', true);
            } elseif ($request->type === 'standard') {
                $query->where(function ($q) {
                    $q->where('is_featured', false)
                        ->orWhereNull('is_featured');
                });
            }
        }

        // 🏢 Employer
        if ($request->filled('employer')) {
            $query->where('user_id', $request->employer);
        }

        // Get the filtered jobs with view count
        $jobs = $query->latest()->paginate(10)->withQueryString();

        // Stats for the dashboard
        $totalViews = \App\Models\JobView::count();
        $uniqueViewers = \App\Models\JobView::distinct('ip')->count('ip');
        $topJobs = Job_post::withCount('jobViews')
            ->orderByDesc('job_views_count')
            ->take(5)
            ->get();

        $employers = \App\Models\User::where('role', 'employer')->get();

        return view('admin.jobs.index', compact('jobs', 'employers', 'totalViews', 'uniqueViewers', 'topJobs'));
    }


    public function export(Request $request)
    {
        $query = Job_post::query();

        // Apply same filters
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                    ->orWhere('company_name', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('type')) {
            if ($request->type === 'featured') {
                $query->where('is_featured', true);
            } else {
                $query->where('is_featured', false);
            }
        }

        if ($request->filled('employer')) {
            $query->where('employer_id', $request->employer);
        }

        $jobs = $query->latest()->get();

        $csvData = "Title,Company,Location,Type,Status\n";

        foreach ($jobs as $job) {
            $csvData .= "\"{$job->title}\","
                . "\"{$job->company_name}\","
                . "\"{$job->location}\","
                . "\"{$job->job_type}\","
                . "\"{$job->status}\"\n";
        }

        return response($csvData)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename="jobs_export.csv"');
    }

    public function toggleFeatured(Job_post $job)
    {
        $job->is_featured = !$job->is_featured;
        $job->save();

        return response()->json([
            'success' => true,
            'is_featured' => $job->is_featured
        ]);
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.jobs.create', compact('categories'));
    }

    /*
    |--------------------------------------------------------------------------
    | STORE JOB
    |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title'             => 'required|string|max:255',
            'company_name'      => 'required|string|max:255',
            'is_verified' => 'nullable|boolean',
            'about_company' => 'nullable|string|max:2000',
            'company_logo'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'category_id'       => 'required|exists:categories,id',
            'job_type'          => 'required',
            'location'          => 'required',
            'is_remote'         => 'nullable|boolean',
            'apply_url'         => 'required|url',
            'short_description' => 'required',
            'deadline'          => 'nullable|date',
            'status'            => 'required|in:active,expired,inactive',
            'is_featured'       => 'nullable|boolean',
            'experience_level'  => 'nullable|string',
            'salary_range'      => 'nullable|string',
            'source'            => 'nullable|string',
            // 'uuid' => (string) Str::uuid(),
            'is_paid' => true, // Mark as paid by default for admin-created jobs
            'is_approved' => true, // Mark as approved by default for admin-created jobs
        ]);

        /*
        | Remote override
        */
        if ($request->boolean('is_remote')) {
            $data['location'] = 'Remote';
        }

        $data['uuid'] = (string) Str::uuid();

        /*
        | Upload logo
        */
        if ($request->hasFile('company_logo')) {
            $path = $request->file('company_logo')->store('logos', 'public');
            $data['company_logo'] = 'storage/' . $path;
        }

        $job = Job_post::create($data);

        /*
        | Email alerts (queue)
        */
        // $alerts = JobAlert::where('is_active', true)->get();
        $alerts = JobAlert::where('is_active', true)
            ->where('alert_type', 'job')->get();

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
                . "🔗 " . route('jobs.show', $job);

            Http::post(
                "https://api.telegram.org/bot" . config('services.telegram.bot_token') . "/sendMessage",
                [
                    'chat_id' => config('services.telegram.chat_id'),
                    'text' => $message,
                    'parse_mode' => 'Markdown'
                ]
            );
        }

        return redirect()->route('admin.jobs.index')
            ->with('success', 'Job posted, alerts sent & Telegram notified!');
    }


    /*
    |--------------------------------------------------------------------------
    | EDIT
    |--------------------------------------------------------------------------
    */
    public function edit(Job_post $job)
    {
        $categories = Category::all();
        return view('admin.jobs.edit', compact('job', 'categories'));
    }


    /*
    |--------------------------------------------------------------------------
    | UPDATE JOB
    |--------------------------------------------------------------------------
    */
    public function update(Request $request, Job_post $job)
    {
        $data = $request->validate([
            'title'             => 'required|string|max:255',
            'company_name'      => 'required|string|max:255',
            'is_verified' => 'nullable|boolean',
            'about_company' => 'nullable|string|max:2000',
            'company_logo'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'category_id'       => 'required|exists:categories,id',
            'job_type'          => 'required',
            'location'          => 'required',
            'is_remote'         => 'nullable|boolean',
            'apply_url'         => 'required|url',
            'short_description' => 'required',
            'deadline'          => 'nullable|date',
            'status'            => 'required|in:active,inactive',
            'is_featured'       => 'nullable|boolean',
            'experience_level'  => 'nullable|string',
            'salary_range'      => 'nullable|string',
            'source'            => 'nullable|string',
            // 'uuid' => (string) Str::uuid(),
        ]);

        /*
        | Remote override
        */
        if ($request->boolean('is_remote')) {
            $data['location'] = 'Remote';
        }

        $data['uuid'] = (string) Str::uuid();

        /*
        | Replace logo if uploaded
        */
        if ($request->hasFile('company_logo')) {

            // delete old
            if ($job->company_logo) {
                Storage::disk('public')->delete(
                    str_replace('storage/', '', $job->company_logo)
                );
            }

            $path = $request->file('company_logo')->store('logos', 'public');
            $data['company_logo'] = 'storage/' . $path;
        }

        $job->update($data);

        return redirect()->route('admin.jobs.index')
            ->with('success', 'Job updated successfully!');
    }

    public function pending()
    {
        $pendingJobs = Job_post::where('status', 'pending')
            ->latest()
            ->get();

        return view('admin.jobs.pending', compact('pendingJobs'));
    }



    /*
    |--------------------------------------------------------------------------
    | DELETE
    |--------------------------------------------------------------------------
    */

    public function trash(Request $request)
    {
        $query = Job_post::onlyTrashed()->with('user');

        // 🔍 Search by title or company
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('company_name', 'like', "%{$search}%");
            });
        }

        // 📌 Filter by job type
        if ($request->filled('type')) {
            $query->where('job_type', $request->type);
        }

        // 🗓️ Filter by deleted date
        if ($request->filled('deleted')) {
            switch ($request->deleted) {
                case 'today':
                    $query->whereDate('deleted_at', now());
                    break;
                case 'week':
                    $query->whereBetween('deleted_at', [now()->startOfWeek(), now()->endOfWeek()]);
                    break;
                case 'month':
                    $query->whereMonth('deleted_at', now()->month);
                    break;
            }
        }

        // 🔄 Sorting
        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'oldest':
                    $query->orderBy('deleted_at', 'asc');
                    break;
                case 'expiring':
                    $query->orderBy('ends_at', 'asc'); // if you track ends_at
                    break;
                default:
                    $query->orderBy('deleted_at', 'desc');
                    break;
            }
        } else {
            $query->orderBy('deleted_at', 'desc');
        }

        // 👇 This preserves filters in pagination links
        $jobs = $query->paginate(20)->appends($request->query());

        return view('admin.jobs.trash', compact('jobs'));
    }


    public function restore($id)
    {
        $job = Job_post::onlyTrashed()->findOrFail($id);

        $job->restore();

        return back()->with('success', 'Job restored successfully.');
    }

    public function forceDelete($id)
    {
        $job = Job_post::onlyTrashed()->findOrFail($id);

        $job->forceDelete();

        return back()->with('success', 'Job permanently deleted.');
    }

    public function destroy(Job_post $job)
    {
        if ($job->company_logo) {
            Storage::disk('public')->delete(
                str_replace('storage/', '', $job->company_logo)
            );
        }

        $job->delete();

        return back()->with('success', 'Job deleted');
    }
}
