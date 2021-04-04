<?php

namespace App\Jobs;

use App\Models\Invoice;
use App\Models\Customer;
use App\Notifications\InvoiceNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class QueueInvoiceNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public Invoice $invoice;
    public Customer $customer;
    public ?string $subject;
    public ?string $greeting;
    public ?string $note;
    public ?string $footer;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Invoice $invoice, Customer $customer, ?string $subject = null, ?string $greeting = null, ?string $note = null, ?string $footer = null)
    {
        $this->invoice = $invoice;
        $this->customer = $customer;
        $this->subject = $subject;
        $this->greeting = $greeting;
        $this->note = $note;
        $this->footer = $footer;
    }   

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->customer->notify(
            new InvoiceNotification(
                $this->invoice, 
                $this->subject, 
                $this->greeting, 
                $this->note, 
                $this->footer
            )
        );
    }
}
