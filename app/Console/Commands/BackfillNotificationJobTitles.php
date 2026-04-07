<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Notifications\DatabaseNotification;
use App\Models\Job_post;

class BackfillNotificationJobTitles extends Command
{
    protected $signature = 'notifications:backfill-job-titles';
    protected $description = 'Add job_title to existing JobReportedNotification records';

    public function handle()
    {
        $this->info('Starting backfill of job titles...');

        DatabaseNotification::where('type', \App\Notifications\JobReportedNotification::class)
            ->get()
            ->each(function ($notification) {
                $data = $notification->data;

                if (!isset($data['job_title']) && isset($data['job_post_id'])) {
                    $job = \App\Models\Job_post::find($data['job_post_id']);
                    if ($job) {
                        $data['job_uuid'] = $job->uuid;
                        $data['job_slug'] = $job->slug;
                        $data['job_title'] = $job->title;
                        $notification->update(['data' => $data]);
                        $this->line("Updated notification {$notification->id} with job title '{$job->title}'");
                    } else {
                        $this->warn("Job not found for job_post_id {$data['job_post_id']} in notification {$notification->id}");
                    }
                }
            });

        $this->info('Backfill complete.');
    }
}
