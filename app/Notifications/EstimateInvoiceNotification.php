<?php

namespace App\Notifications;

use App\Models\EstimateInvoice;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EstimateInvoiceNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public EstimateInvoice $estimateInvoice;
    public ?string $subject;
    public ?string $greeting;
    public ?string $note;
    public ?string $footer;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(EstimateInvoice $estimateInvoice, ?string $subject = 'Estimate Invoice Receipt', ?string $greeting = null, ?string $note = null, ?string $footer = null)
    {
        $this->estimateInvoice = $estimateInvoice;
        $this->subject = $subject;
        $this->greeting = $greeting;
        $this->note = $note;
        $this->footer = $footer;
    }   

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject($this->subject)
            ->greeting($this->greeting ?? "Hi {$notifiable->name},")
            ->line("")
            ->line("I hope you’re well! This your e-estimate-invoice with an id of {$this->estimateInvoice->estimate_number}")
            ->line("Due on {$this->estimateInvoice->due_date} Don’t hesitate to reach out if you have any questions,")
            ->line('don\'t hesitate to ask.')
            ->line('Thank you for your patronage.!')
            ->line($this->note);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
        return [
            'name' => $notifiable->name, 
            'type' => 'Estimate Invoice',
            'message' => 'An email was sent through the user\'s gmail account about the estimate invoice details.',
            'iconName' => 'ReceiptIcon'
        ];
    }
}
