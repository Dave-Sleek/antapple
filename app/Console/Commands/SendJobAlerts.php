<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Mail\JobAlertMail;
use Illuminate\Support\Facades\Mail;
use App\Models\JobAlert;
use App\Models\Job_post;
use App\Models\Opportunity;
use App\Mail\OpportunityAlertMail;

class SendJobAlerts extends Command
{
    protected $signature = 'alerts:send';
    protected $description = 'Send job alerts to subscribers based on their preferences';
    

    public function handle()
{
    $alerts = JobAlert::where('is_active', true)->get();

    if ($alerts->isEmpty()) {
        $this->info('No active alerts found.');
        return;
    }

    foreach ($alerts as $alert) {

        /*
        |--------------------------------------------------------------------------
        | JOB ALERTS
        |--------------------------------------------------------------------------
        */
        if (($alert->alert_type ?? 'job') === 'job') {

                $query = Job_post::active();

                if ($alert->last_sent_at) {
                    $query->where('created_at', '>', $alert->last_sent_at);
                }

                if ($alert->category_id) {
                    $query->where('category_id', $alert->category_id);
                }

                if ($alert->remote_only && !$alert->location) {
                    $query->where('is_remote', true);
                } elseif ($alert->location) {

                    $locations = array_map('trim', explode(',', $alert->location));

                    $query->where(function ($q) use ($locations, $alert) {
                        foreach ($locations as $loc) {
                            $q->orWhere('location', 'like', "%{$loc}%");
                        }

                        if ($alert->remote_only) {
                            $q->orWhere('is_remote', true);
                        }
                    });
                }

                $jobs = $query->orderByDesc('is_featured')
                    ->latest()
                    ->take(10)
                    ->get();

                if ($jobs->isNotEmpty()) {
                    Mail::to($alert->email)->queue(new JobAlertMail($jobs, $alert));

                    $alert->update(['last_sent_at' => now()]);

                    $this->info("✅ Jobs sent to {$alert->email}");
                } else {
                    $this->info("ℹ️ No jobs for {$alert->email}");
                }
            }

        /*
        |--------------------------------------------------------------------------
        | OPPORTUNITY ALERTS
        |--------------------------------------------------------------------------
        */
        if ($alert->alert_type === 'opportunity') {

            $query = Opportunity::query();

            if ($alert->last_sent_at) {
                $query->where('created_at', '>', $alert->last_sent_at);
            }

            // Filter by opportunity type
            if ($alert->opportunity_type) {
                $query->where('type', $alert->opportunity_type);
            }

            // Filter by location
            if ($alert->location) {
                $query->where('location', 'like', "%{$alert->location}%");
            }

            $opportunities = $query->latest()
                ->take(10)
                ->get();

            if ($opportunities->count()) {

                Mail::to($alert->email)
                    ->queue(new \App\Mail\OpportunityAlertMail($opportunities, $alert));

                $alert->update(['last_sent_at' => now()]);

                $this->info("🎯 Opportunities sent to {$alert->email}");
            } else {
                $this->info("ℹ️ No opportunities for {$alert->email}");
            }
        }
    }

    $this->info('All alerts processed.');
}}
