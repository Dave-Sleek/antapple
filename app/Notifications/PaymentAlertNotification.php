<?php

namespace App\Notifications;

use App\Models\Payment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class PaymentAlertNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $payment;

    public function __construct(Payment $payment)
    {
        $this->payment = $payment;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Payment Alert')
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line('We have received a payment update.')
            ->line('Reference: ' . $this->payment->reference)
            ->line('Amount: ' . $this->payment->amount . ' ' . $this->payment->currency)
            ->line('Status: ' . ucfirst($this->payment->status))
            ->action('View Payment', url('/payments/' . $this->payment->id))
            ->line('Thank you for your subscription!');
    }

    public function toArray($notifiable)
    {
        return [
            'payment_id' => $this->payment->id,
            'reference'  => $this->payment->reference,
            'amount'     => $this->payment->amount,
            'currency'   => $this->payment->currency,
            'status'     => $this->payment->status,
        ];
    }
}
