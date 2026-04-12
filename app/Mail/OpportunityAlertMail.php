<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Opportunity;

class OpportunityAlertMail extends Mailable
{
    use Queueable, SerializesModels;

    public $opportunities;
    public $alert;

    public function __construct($opportunities, $alert)
    {
        $this->opportunities = $opportunities;
        $this->alert = $alert;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Opportunities For You 🚀',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.opportunity_alert',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}