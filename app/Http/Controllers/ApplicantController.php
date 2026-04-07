<?php

namespace App\Http\Controllers;

use App\Models\Applicant;
use App\Models\Job_post;
use Illuminate\Http\Request;
use App\Notifications\JobAppliedNotification;

class ApplicantController extends Controller
{
    public function create(Job_post $job)
    {
        // Only approved jobs can be applied for internally
        if ($job->status !== 'active') {
            abort(403, 'Job not available for application.');
        }

        return view('jobs.apply', compact('job'));
    }

    public function store(Request $request, Job_post $job)
    {
        if ($job->status !== 'active') {
            abort(403, 'Job not available for application.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'resume' => 'required|file|mimes:pdf,doc,docx|max:2048',
            'cover_letter' => 'nullable|string'
        ]);

        if (Applicant::where('job_post_id', $job->id)
            ->where('email', $request->email)
            ->exists()
        ) {
            return back()->with('error', 'You have already applied for this job.');
        }

        $resumePath = $request->file('resume')->store('resumes', 'public');

        $application = Applicant::create([
            'job_post_id' => $job->id,
            'name' => $request->name,
            'email' => $request->email,
            'resume' => $resumePath,
            'cover_letter' => $request->cover_letter,
        ]);

        if ($job->user) {
            $job->user->notify(new JobAppliedNotification($application));
        }

        return redirect()
            ->route('jobs.show', $job->id)
            ->with('success', 'Application submitted successfully!');
    }
}
