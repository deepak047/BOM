<?php

namespace App\Notifications;

use App\Models\PurchaseIntent;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Queue\Middleware\RateLimited;

class PurchaseIntentCreated extends Notification implements ShouldQueue
{
    use Queueable;

   
    public $tries = 3;

    
    public $backoff = 60;

    /**
     * Get the middleware the job should pass through.
     *
     * @return array<int, object>
     */
    public function middleware(): array
    {
        return [new RateLimited('email-outbound')];
    }

    /**
     * Create a new notification instance.
     */
    public function __construct(public PurchaseIntent $intent)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via($notifiable): array
    {
        return ['database', 'mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
        ->subject('New Purchase Intent Raised')
        ->view('emails.purchase_intent', [
            'intent' => $this->intent,
        ]);
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray($notifiable): array
    {
        return [
            'message'       => "New purchase intent raised for item #{$this->intent->id}",
            'bom_reference' => $this->intent->bom_reference,
            'intent_id'     => $this->intent->id,
        ];
    }
}