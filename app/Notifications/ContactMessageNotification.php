<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ContactMessageNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $contact;

    public function __construct($contact)
    {
        $this->contact = $contact;
    }

    public function via($notifiable)
    {
        // You can add 'database' or 'slack' here if needed
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('New Contact Message Received')
            ->greeting('Hello Admin,')
            ->line('A new contact message has been submitted.')
            ->line('Name: ' . $this->contact->name)
            ->line('Email: ' . $this->contact->email)
            ->line('Message: ' . $this->contact->message)
            ->action('View Message', url('/admin/contacts/' . $this->contact->id))
            ->line('Thank you for staying on top of communications!');
    }

    public function toArray($notifiable)
    {
        return [
            'contact_id' => $this->contact->id,
            'name'       => $this->contact->name,
            'email'      => $this->contact->email,
            'message'    => $this->contact->message,
        ];
    }
}
