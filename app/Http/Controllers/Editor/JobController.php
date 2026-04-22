<?php

namespace App\Http\Controllers\Editor;

use App\Http\Controllers\Controller;
use App\Models\Job_post;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\JobAlert;
use App\Mail\JobAlertMail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class JobController extends Controller
{
    public function index()
    {
        $jobs = Job_post::latest()->paginate(10);
        return view('editor.jobs.index', compact('jobs'));
    }

    public function create()
    {
        return view('editor.jobs.create');
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
        'is_verified'       => 'nullable|boolean',
        'about_company'     => 'nullable|string|max:2000',
        'company_logo'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        'category_id'       => 'required|exists:categories,id',
        'job_type'          => 'required',
        'location'          => 'required',
        'is_remote'         => 'nullable|boolean',
        'apply_url'         => 'required|url',
        'short_description' => 'required',
        'deadline'          => 'nullable|date',
        'is_featured'       => 'nullable|boolean',
        'experience_level'  => 'nullable|string',
        'salary_range'      => 'nullable|string',
        'source'            => 'nullable|string',
    ]);

    /*
    | Remote override
    */
    if ($request->boolean('is_remote')) {
        $data['location'] = 'Remote';
    }

    /*
    | Draft vs Publish logic
    */
    $action = $request->input('action', 'draft');

    if ($action === 'publish') {
        $data['status'] = 'active';
        $data['published_at'] = now();
    } else {
        $data['status'] = 'draft';
    }

    $data['uuid'] = (string) Str::uuid();
    $data['is_paid'] = true;
    $data['is_approved'] = true;

    /*
    | Upload logo
    */
    if ($request->hasFile('company_logo')) {
        $path = $request->file('company_logo')->store('logos', 'public');
        $data['company_logo'] = $path;
    }

    $job = Auth::user()->jobs()->create($data);

    Cache::flush();

    /*
    | Ping Google ONLY if published
    */
    if ($data['status'] === 'active') {
        Http::get('https://www.google.com/ping', [
            'sitemap' => url('/sitemap.xml')
        ]);
    }

    /*
    | Email alerts ONLY if published
    */
    if ($data['status'] === 'active') {
        $alerts = JobAlert::where('is_active', true)
            ->where('alert_type', 'job')
            ->get();

        foreach ($alerts as $alert) {
            Mail::to($alert->email)
                ->queue(new JobAlertMail(collect([$job]), $alert));
        }
    }

    /*
    | Telegram notify ONLY if published
    */
    if ($job->status === 'active' && config('services.telegram.bot_token')) {

        $message = "🚀 *New Job Posted*\n\n"
            . "*{$job->title}*\n"
            . "🏢 {$job->company_name}\n"
            . "📍 {$job->location}\n"
            . "💼 {$job->job_type}\n"
            . "🔗 " . route('jobs.show', [
                'job' => $job->uuid,
                'slug' => \Illuminate\Support\Str::slug($job->title),
            ]);

        Http::post(
            "https://api.telegram.org/bot" . config('services.telegram.bot_token') . "/sendMessage",
            [
                'chat_id' => config('services.telegram.chat_id'),
                'text' => $message,
                'parse_mode' => 'Markdown'
            ]
        );
    }

    return redirect()->route('editor-jobs.index')
        ->with('success', $action === 'publish'
            ? 'Job published successfully!'
            : 'Draft saved successfully!');
}


    /*
    |--------------------------------------------------------------------------
    | EDIT
    |--------------------------------------------------------------------------
    */
    public function edit(Job_post $job)
    {
        $categories = Category::all();
        return view('editor.jobs.edit', compact('job', 'categories'));
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
            'is_verified'       => 'nullable|boolean',
            'about_company'     => 'nullable|string|max:2000',
            'company_logo'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'category_id'       => 'required|exists:categories,id',
            'job_type'          => 'required',
            'location'          => 'required',
            'is_remote'         => 'nullable|boolean',
            'apply_url'         => 'required|url',
            'short_description' => 'required',
            'deadline'          => 'nullable|date',
            'status'            => 'required|in:active,expired,inactive,draft',
            'is_featured'       => 'nullable|boolean',
            'experience_level'  => 'nullable|string',
            'salary_range'      => 'nullable|string',
            'source'            => 'nullable|string',
        ]);

        /*
        | Remote override
        */
        if ($request->boolean('is_remote')) {
            $data['location'] = 'Remote';
        }

        $data['is_paid'] = true;
        $data['is_approved'] = true;

        /*
        | Replace logo if uploaded
        */
        if ($request->hasFile('company_logo')) {

            // delete old
            if ($request->hasFile('company_logo')) {
                if ($job->company_logo) {
                    Storage::disk('public')->delete($job->company_logo);
                }

                $path = $request->file('company_logo')->store('logos', 'public');
                $data['company_logo'] = $path;
            }
        }

        $job->update($data);

        return redirect()->route('editor-jobs.index')
            ->with('success', 'Job updated successfully!');
    }
    

    public function drafts(Request $request)
        {
            $query = \App\Models\Job_post::where('status', 'draft')
                ->with('user')
                ->latest();

            // Optional search
            if ($request->filled('search')) {
                $query->where('title', 'like', '%' . $request->search . '%');
            }

            $jobs = $query->paginate(20)->appends($request->query());

            return view('editor.jobs.drafts', compact('jobs'));
        }

    public function publish(\App\Models\Job_post $job)
        {
            $job->update([
                'status' => 'active',
                'published_at' => now()
            ]);

            return back()->with('success', 'Job published successfully!');
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

        return view('editor.jobs.trash', compact('jobs'));
    }


    public function restore($id)
        {
            $job = Job_post::onlyTrashed()->findOrFail($id);

            $user = Auth::user();

            if ($user->isAdmin()) {
                $job->restore();
            } elseif ($user->isEditor()) {
                // Optional restriction
                // if ($job->user_id !== $user->id) abort(403);

                $job->restore();
            }

            return back()->with('success', 'Job restored successfully.');
        }

    public function forceDelete($id)
        {
            $job = Job_post::onlyTrashed()->findOrFail($id);

            if (!Auth::user()->isAdmin()) {
                abort(403, 'Only admin can permanently delete.');
            }

            $job->forceDelete();

            return back()->with('success', 'Job permanently deleted.');
        }

    // Delete Job
    public function destroy(Job_post $job)
    {
        $user = Auth::user();

        // Admin can delete anything
        if ($user->isAdmin()) {
            $job->delete();
            return back()->with('success', 'Job moved to trash.');
        }

        // Editor: allow deleting all (WordPress style)
        if ($user->isEditor()) {
            $job->delete();
            return back()->with('success', 'Job moved to trash.');
        }

        abort(403);
    }
}