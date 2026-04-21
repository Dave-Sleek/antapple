<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Job;
use App\Models\Job_post;
use Illuminate\Http\Request;
use App\Notifications\JobReportedNotification;
use App\Models\User;
use Illuminate\Support\Facades\Http;

class ReportController extends Controller
{
    public function store(Request $request, Job_post $job)
{
    $request->validate([
        'reason' => 'required',
        'message' => 'nullable',
        'g-recaptcha-response' => 'required',
    ]);

    // Verify reCAPTCHA
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://www.google.com/recaptcha/api/siteverify');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
        'secret'   => config('services.recaptcha.secret'),
        'response' => $request->input('g-recaptcha-response'),
        'remoteip' => $request->ip(),
    ]));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $raw = curl_exec($ch);
    curl_close($ch);

    $result = json_decode($raw, true);

    if (!($result['success'] ?? false)) {
        return back()->withErrors(['captcha' => 'reCAPTCHA failed. Try again.']);
    }

    // Save report
    $report = Report::create([
        'job_post_id' => $job->id,
        'reason'      => $request->reason,
        'message'     => $request->message,
    ]);

    // Notify employer (if exists)
    $employer = User::where('role', 'employer')->first();
    if ($employer) {
        $employer->notify(new JobReportedNotification($report));
    }

    // Notify admin (if exists)
    $admin = User::where('role', 'admin')->first();
    if ($admin) {
        $admin->notify(new JobReportedNotification($report));
    }

    return back()->with('success', 'Report submitted');
    }

}
