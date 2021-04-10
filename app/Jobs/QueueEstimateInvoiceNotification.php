<?php

namespace App\Jobs;

use App\Models\Customer;
use Illuminate\Bus\Queueable;
use App\Models\EstimateInvoice;
use App\Notifications\EstimateInvoiceNotification;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class QueueEstimateInvoiceNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public EstimateInvoice $estimateInvoice;
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
    public function __construct(EstimateInvoice $estimateInvoice, Customer $customer, ?string $subject = null, ?string $greeting = null, ?string $note = null, ?string $footer = null)
    {
        $this->estimateInvoice = $estimateInvoice;
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
            new EstimateInvoiceNotification(
                $this->estimateInvoice, 
                $this->subject, 
                $this->greeting, 
                $this->note, 
                $this->footer
            )
        );
    }
}
