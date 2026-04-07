<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Job_post;
use App\Models\Subscription;

class ExpiredFeaturedJobs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jobs:expired-featured';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Expire featured jobs that have passed their featured_until date';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $expiredJobs = Job_post::where('is_featured', true)
            ->where('featured_until', '<', now())
            ->where('featured_until', '<', now())
            ->update([
                'is_featured' => false,
                'featured_until' => null,
            ]);

        $expiredUserIds = Subscription::where('status', '!=', 'successful')
            ->pluck('user_id');
        Job_post::whereIn('user_id', $expiredUserIds)
            ->where('is_featured', true)
            ->updated([
                'is_featured' => false,
                'featured_until' => null,
            ]);
        $this->info('Expired featured jobs & cleaned expired subscriptions.');
    }
}
