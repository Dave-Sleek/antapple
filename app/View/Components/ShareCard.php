<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Str;

class ShareCard extends Component
{
    public $job;
    public $jobUrl;
    public $shareText;

    public function __construct($job)
    {
        $this->job = $job;

        $this->jobUrl = route('jobs.show', [
            'job' => $job->uuid,
            'slug' => $job->slug ?? Str::slug($job->title),
        ]);

        $this->shareText = $job->title . ' at ' . $job->company_name;
    }

    public function render()
    {
        return view('components.share-card');
    }
}