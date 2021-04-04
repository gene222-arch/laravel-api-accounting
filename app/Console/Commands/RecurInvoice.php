<?php

namespace App\Console\Commands;

use App\Jobs\QueueInvoiceNotification;
use App\Models\Customer;
use App\Models\Invoice;
use Carbon\Carbon;
use Illuminate\Console\Command;

class RecurInvoice extends Command
{
    
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'invoice:recur';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Mail customer an invoice receipt in interval basis';

    public Invoice $invoice;
    public Customer $customer;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Invoice $invoice, Customer $customer)
    {
        parent::__construct();
        $this->invoice = $invoice;
        $this->customer = $customer;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        dispatch(new QueueInvoiceNotification(
            $this->invoice,
            $this->customer
        ));
    }
}
