<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class JobAlertMail extends Mailable
{
    public $jobs;
    public $alert;

    public function __construct($jobs, $alert)
    {
        $this->jobs = $jobs;
        $this->alert = $alert;
    }

    public function build()
    {
        return $this->subject('New Jobs Matching Your Preferences')
            ->view('emails.job-alert');
    }
}
