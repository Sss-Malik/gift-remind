<?php

namespace App\Notifications;

use App\Models\Event;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;

class EventReminder extends Notification
{
    use Queueable;

    public $event;

    /**
     * Create a new notification instance.
     */
    public function __construct(Event $event)
    {
        $this->event = $event;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $daysLeft = $this->event->notification_days;
        $recipientName = $this->event->recipient->name;
        $eventName = $this->event->title;
        $paymentStatus = $this->event->payment ? $this->event->payment->status : 'unpaid';

        $mail = (new MailMessage)
            ->subject("Reminder: $eventName is in $daysLeft days!")
            ->greeting("Hello $notifiable->name,")
            ->line("This is a reminder that **$eventName** for **$recipientName** is coming up on " . $this->event->event_date->format('M d, Y') . ".")
            ->line("Gift Status: " . ($this->event->gift ? $this->event->gift->name : 'No gift selected'));

        // Dynamic Call to Action based on Payment Status
        if ($paymentStatus === 'unpaid' || $paymentStatus === 'rejected') {
            $mail->line('⚠️ **Action Required:** You have not completed the payment for this gift yet.')
                ->action('Pay Now', route('payments.create', $this->event->id));
        } elseif ($paymentStatus === 'pending') {
            $mail->line('ℹ️ Your payment is currently under review by our team.');
            $mail->action('View Event', route('events.index'));
        } else {
            $mail->line('✅ Payment Approved. We will handle the delivery!');
            $mail->action('View Event', route('events.index'));
        }

        return $mail;
    }

    // 2. SMS Channel (Stub / Placeholder)
    // Laravel doesn't have a default "SMS" channel file driver, so we simulate it here.
    // In a real app, you would use 'vonage' or 'twilio' drivers.
    public function toSmsStub(object $notifiable)
    {
        $message = "GiftSync Reminder: {$this->event->title} for {$this->event->recipient->name} is in {$this->event->notification_days} days. Check your dashboard.";

        // Log it to simulate sending
        Log::channel('daily')->info("SMS SENT to {$notifiable->phone}: $message");
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
