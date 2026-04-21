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
            'status'            => 'required|in:active,expired,inactive',
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

        $data['uuid'] = (string) Str::uuid();
        $data['is_paid'] = true;
        $data['is_approved'] = true;

        /*
        | Upload logo
        */
        if ($request->hasFile('company_logo')) {
                $path = $request->file('company_logo')->store('logos', 'public');
                $data['company_logo'] = $path; // e.g. "logos/filename.png"
            }


        // $job = Job_post::create($data);
        $job = Auth::user()->jobs()->create($data);
        
        Cache::flush(); // Clear cache after creating a job

        // Ping Google to update sitemap
        Http::get('https://www.google.com/ping', [
            'sitemap' => url('/sitemap.xml')
        ]);

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
                . "🔗 " . route('jobs.show', [
                        'job' => $job->uuid,
                        'slug' => \Illuminate\Support\Str::slug($job->title),
                    ]);
                // . "🔗 " . route('jobs.show', $job);

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
            'status'            => 'required|in:active,expired,inactive',
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
                // delete old
                if ($job->company_logo) {
                    Storage::disk('public')->delete($job->company_logo);
                }

                // store new
                $path = $request->file('company_logo')->store('logos', 'public');
                $data['company_logo'] = $path; // e.g. "logos/company1.png"
            }
        }

        $job->update($data);

        return redirect()->route('editor-jobs.index')
            ->with('success', 'Job updated successfully!');
    }
    
    // public function edit(Job_post $job)
    // {
    //     return view('editor.jobs.edit', compact('job'));
    // }

    // public function update(Request $request, Job_post $job)
    // {
    //     $job->update($request->all());

    //     return redirect()->route('ejobs.index')->with('success', 'Updated');
    // }

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