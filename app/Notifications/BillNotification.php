<?php

namespace App\Notifications;

use App\Models\Bill;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class BillNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public Bill $bill;
    public ?string $subject;
    public ?string $greeting;
    public ?string $note;
    public ?string $footer;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Bill $bill, ?string $subject = 'Bill Receipt', ?string $greeting = null, ?string $note = null, ?string $footer = null)
    {
        $this->bill = $bill;
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
            ->line("I hope you’re well! This your e-bill with an id of {$this->bill->bill_number}")
            ->line("Due on {$this->bill->due_date} Don’t hesitate to reach out if you have any questions,")
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
            'type' => 'Bill',
            'message' => 'An email was sent through the user\'s gmail account about the reset password details.',
            'iconName' => 'ReceiptIcon'
        ];
    }
}
