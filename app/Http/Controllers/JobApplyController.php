<?php

namespace App\Http\Controllers;

use App\Models\Job_post;
use App\Models\JobClick;
use Illuminate\Http\Request;


class JobApplyController extends Controller
{
    public function __invoke(Job_post $job, Request $request)
    {
        JobClick::create([
            'job_post_id' => $job->id,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'clicked_at' => now(),
        ]);

        return redirect()->away($job->apply_url);
    }

    public function show(Job_post $job_post)
    {
        return view('jobs.show', ['job' => $job_post]);
    }
}
