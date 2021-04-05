<?php

namespace App\Jobs;

use App\Models\Bill;
use App\Models\Vendor;
use App\Notifications\BillNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class QueueBillNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public Bill $bill;
    public Vendor $vendor;
    public ?string $subject;
    public ?string $greeting;
    public ?string $note;
    public ?string $footer;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Bill $bill, Vendor $vendor, ?string $subject = null, ?string $greeting = null, ?string $note = null, ?string $footer = null)
    {
        $this->bill = $bill;
        $this->vendor = $vendor;
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
        $this->vendor->notify(
            new BillNotification(
                $this->bill, 
                $this->subject, 
                $this->greeting, 
                $this->note, 
                $this->footer
            )
        );
    }
}
