<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Job_post;

class ExpireJobs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    // protected $signature = 'app:expire-jobs';
    protected $signature = 'jobs:expire';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Expire jobs past deadline';
    // protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Job_post::whereNotNull('deadline')
            ->where('deadline', '<', now())
            ->update(['status' => 'expired']);
    }
}
