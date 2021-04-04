<?php

namespace App\Notifications;

use App\Models\Invoice;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class InvoiceNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public Invoice $invoice;
    public ?string $subject;
    public ?string $greeting;
    public ?string $note;
    public ?string $footer;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Invoice $invoice, ?string $subject = 'Invoice Receipt', ?string $greeting = null, ?string $note = null, ?string $footer = null)
    {
        $this->invoice = $invoice;
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
            ->line("I hope you’re well! This your e-invoice with an id of {$this->invoice->invoice_number}")
            ->line("Due on {$this->invoice->due_date} Don’t hesitate to reach out if you have any questions,")
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
            'type' => 'Invoice',
            'message' => 'An email was sent through the user\'s gmail account about the reset password details.',
            'iconName' => 'ReceiptIcon'
        ];
    }
}
