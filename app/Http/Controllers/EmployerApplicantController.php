<?php

namespace App\Http\Controllers;

use App\Models\Applicant;
use App\Models\Job_post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployerApplicantController extends Controller
{
    public function index()
    {
        $user = auth::user();

        // Get employer jobs with applicants count
        $jobs = Job_post::where('user_id', $user->id)
            ->withCount('applicants')
            ->with('applicants')
            ->latest()
            ->get();

        return view('employer.applicants.index', compact('jobs'));
    }

    public function show($id)
    {
        $applicant = Applicant::with('job')
            ->findOrFail($id);

        // Security: Ensure employer owns this job
        if ($applicant->job->user_id !== auth::id()) {
            abort(403);
        }

        return view('employer.applicants.show', compact('applicant'));
    }
}
