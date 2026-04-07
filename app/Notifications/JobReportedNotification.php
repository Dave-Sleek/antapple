<?php

namespace App\Notifications;

use App\Models\Report;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class JobReportedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $report;

    public function __construct(Report $report)
    {
        $this->report = $report;
    }

    public function via($notifiable)
    {
        return ['mail', 'database']; // store + email
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Job Report Submitted')
            ->greeting('Hello Admin,')
            ->line('A job has been reported.')
            ->line('Job ID: ' . $this->report->job_post_id)
            ->line('Reason: ' . $this->report->reason)
            ->line('Message: ' . $this->report->message)
            ->action('View Report', url('/admin/reports/' . $this->report->id))
            ->line('Please review this report promptly.');
    }

    public function toArray($notifiable)
    {
        return [
            'report_id'   => $this->report->id,
            'job_post_id' => $this->report->job_post_id,
            'job_title'   => optional($this->report->jobPost)->title, // add this
            'job_uuid'    => optional($this->report->jobPost)->uuid,
            'job_slug'    => optional($this->report->jobPost)->slug,
            'reason'      => $this->report->reason,
            'message'     => $this->report->message,
        ];
    }
}
