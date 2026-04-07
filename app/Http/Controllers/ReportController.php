<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Job;
use App\Models\Job_post;
use Illuminate\Http\Request;
use App\Notifications\JobReportedNotification;
use App\Models\User;

class ReportController extends Controller
{
    public function store(Request $request, Job_post $job)
    {
        $request->validate([
            'reason' => 'required',
            'message' => 'nullable',
        ]);

        $report = Report::create([
            'job_post_id' => $job->id,
            'reason' => $request->reason,
            'message' => $request->message,
        ]);

        $admin = User::where('role', 'admin')->first();
        $admin->notify(new JobReportedNotification($report));

        return back()->with('success', 'Report submitted');
    }
}
