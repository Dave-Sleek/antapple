<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JobAlert;

class AdminJobAlertController extends Controller
{
    public function index()
    {
        $alerts = JobAlert::latest()->paginate(20);
        return view('admin.job-alerts.index', compact('alerts'));
    }

    public function destroy(JobAlert $jobAlert)
    {
        $jobAlert->delete();
        return back()->with('success', 'Alert removed');
    }
}
