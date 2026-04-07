<?php

namespace App\Observers;

use App\Models\Job_post;
use App\Models\JobAlert;
use App\Mail\JobAlertMail;
use Illuminate\Support\Facades\Mail;

class JobPostObserver
{
    /**
     * Handle the Job_post "created" event.
     */
    public function created(Job_post $job)
    {
        // Only send alerts for active jobs
        if ($job->status !== 'active') return;

        // Get all active alerts set to daily
        $alerts = JobAlert::where('is_active', true)
            ->where('frequency', 'daily')
            ->get();

        foreach ($alerts as $alert) {

            $query = Job_post::where('id', $job->id);

            // Filter by category if specified
            if ($alert->category_id) {
                $query->where('category_id', $alert->category_id);
            }

            // Filter by location and/or remote
            if ($alert->location && $alert->remote_only) {
                // Match job location OR remote
                $query->where(function ($q) use ($alert) {
                    $locations = array_map('trim', explode(',', $alert->location));
                    foreach ($locations as $loc) {
                        $q->orWhere('location', 'like', "%{$loc}%");
                    }
                    $q->orWhere('is_remote', true);
                });
            } elseif ($alert->location) {
                // Only match location
                $locations = array_map('trim', explode(',', $alert->location));
                $query->where(function ($q) use ($locations) {
                    foreach ($locations as $loc) {
                        $q->orWhere('location', 'like', "%{$loc}%");
                    }
                });
            } elseif ($alert->remote_only) {
                // Only remote jobs
                $query->where('is_remote', true);
            }

            $jobs = $query->get();

            if ($jobs->count()) {
                Mail::to($alert->email)
                    ->queue(new JobAlertMail($jobs, $alert));
            }
        }
    }
}
