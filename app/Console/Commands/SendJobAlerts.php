<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Mail\JobAlertMail;
use Illuminate\Support\Facades\Mail;
use App\Models\JobAlert;
use App\Models\Job_post;

class SendJobAlerts extends Command
{
    protected $signature = 'alerts:send';
    protected $description = 'Send job alerts to subscribers based on their preferences';

    public function handle()
    {
        $alerts = JobAlert::where('is_active', true)->get();

        if ($alerts->isEmpty()) {
            $this->info('No active job alerts found.');
            return;
        }

        foreach ($alerts as $alert) {

            $query = Job_post::active();

            // Only jobs created after last sent
            if ($alert->last_sent_at) {
                $query->where('created_at', '>', $alert->last_sent_at);
            }

            // Filter by category
            if ($alert->category_id) {
                $query->where('category_id', $alert->category_id);
            }

            // Filter by location(s) and/or remote
            if ($alert->remote_only && !$alert->location) {

                // ONLY remote jobs
                $query->where('is_remote', true);
            } elseif ($alert->location) {

                $locations = array_map('trim', explode(',', $alert->location));

                $query->where(function ($q) use ($locations, $alert) {

                    // Match any location
                    foreach ($locations as $loc) {
                        $q->orWhere('location', 'like', "%{$loc}%");
                    }

                    // If remote is also allowed → include remote
                    if ($alert->remote_only) {
                        $q->orWhere('is_remote', true);
                    }
                });
            }

            // Fetch latest 10 jobs, featured first
            $jobs = $query->orderByDesc('is_featured')
                ->latest()
                ->take(10)
                ->get();

            if ($jobs->count()) {
                // Queue email to subscriber
                Mail::to($alert->email)->queue(new JobAlertMail($jobs, $alert));

                // Update last_sent_at
                $alert->update(['last_sent_at' => now()]);

                $this->info("✅ Sent {$jobs->count()} new job(s) to {$alert->email}");
            } else {
                $this->info("ℹ️ No new jobs for {$alert->email}");
            }
        }

        $this->info('Job alerts processing complete.');
    }
}
