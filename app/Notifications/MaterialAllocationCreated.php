<?php

namespace App\Notifications;

use App\Models\MaterialAllocation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Queue\Middleware\RateLimited;

class MaterialAllocationCreated extends Notification implements ShouldQueue
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
    public function __construct(public MaterialAllocation $allocation)
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
        ->subject('New Material Allocation')
        ->view('emails.allocation', [
            'allocation' => $this->allocation,
        ]);
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray($notifiable): array
    {
        return [
            'message'   => "Materials allocated to {$this->allocation->allocated_to}",
            'item_code' => $this->allocation->item_code,
            'qty'       => $this->allocation->allocated_qty,
        ];
    }
}