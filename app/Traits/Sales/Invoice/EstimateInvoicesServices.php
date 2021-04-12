<?php

namespace App\Traits\Sales\Invoice;

use App\Jobs\QueueEstimateInvoiceNotification;
use App\Models\Customer;
use App\Models\EstimateInvoice;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;

trait EstimateInvoicesServices
{

    /**
     * Create a new record of estimated invoice
     *
     * @param  array $estimate_invoice_details
     * @param  string $estimate_number
     * @param  array $items
     * @param  array $payment_details
     * @return mixed
     */
    public function createEstimateInvoice (array $estimate_invoice_details, string $estimate_number, array $items, array $payment_details): mixed
    {
        try {
            DB::transaction(function () use ($estimate_invoice_details, $estimate_number, $items, $payment_details)
            {
                $estimate_invoice = EstimateInvoice::create($estimate_invoice_details);

                $estimate_invoice->items()->attach($items);

                $estimate_invoice->paymentDetail()->create($payment_details);

                $estimate_invoice->histories()->create([
                    'description' => "${estimate_number} added!"
                ]);
            });
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
        return true;
    }
    
    /**
     * Send a mail to a specified customer.
     *
     * @param  EstimateInvoice $estimate_invoice
     * @param  Customer $customer
     * @param  string $subject
     * @param  string $greeting
     * @param  string $note
     * @param  string $footer
     * @return mixed
     */
    public function mail(EstimateInvoice $estimate_invoice, Customer $customer, ?string $subject, ?string $greeting, ?string $note, ?string $footer): mixed
    {
        try {
            DB::transaction(function () use ($estimate_invoice, $customer, $subject, $greeting, $note, $footer)
            {
                $isCreated = $estimate_invoice->histories()
                    ->create([
                        'status' => 'Mailed',
                        'description' => "Invoice marked as sent!"
                    ]);

                if ($isCreated)
                {
                    dispatch(new QueueEstimateInvoiceNotification(
                        $estimate_invoice, 
                        $customer, 
                        $subject, 
                        $greeting, 
                        $note, 
                        $footer
                    ))
                    ->delay(now()->addSeconds(5));
                }
            });
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
        
        return true;
    }

    /**
     * Mark an estimated invoice as approve
     *
     * @param  EstimateInvoice $estimate_invoice
     * @return mixed
     */
    public function markAsApproved(EstimateInvoice $estimate_invoice): mixed
    {
        try {
            DB::transaction(function () use ($estimate_invoice)
            {
                $estimate_invoice->histories()->create([
                    'status' => 'Approved',
                    'description' => "{$estimate_invoice->estimate_number} marked as approved!"
                ]);

                $estimate_invoice->update([
                    'status' => 'Approved'
                ]);
            });
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
        
        return true;
    }

    /**
     * Mark an estimated invoice as refused
     *
     * @param  EstimateInvoice $estimate_invoice
     * @return mixed
     */
    public function markAsRefused(EstimateInvoice $estimate_invoice): mixed
    {
        try {
            DB::transaction(function () use ($estimate_invoice)
            {
                $estimate_invoice->histories()->create([
                    'status' => 'Refused',
                    'description' => "{$estimate_invoice->estimate_number} marked as refused!"
                ]);

                $estimate_invoice->update([
                    'status' => 'Refused'
                ]);
            });
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
        
        return true;
    }
    
    /**
     * Update an existing record of estimated invoice
     *
     * @param  EstimateInvoice $estimate_invoice
     * @param  array $estimate_invoice_details
     * @param  string $estimate_number
     * @param  array $items
     * @param  array $payment_details
     * @return mixed
     */
    public function updateEstimateInvoice (EstimateInvoice $estimate_invoice, array $estimate_invoice_details, string $estimate_number, array $items, array $payment_details): mixed
    {
        try {
            DB::transaction(function () use ($estimate_invoice, $estimate_invoice_details, $estimate_number, $items, $payment_details)
            {
                $estimate_invoice->update($estimate_invoice_details);

                $estimate_invoice->items()->sync($items);

                $estimate_invoice->paymentDetail()->update($payment_details);

                $estimate_invoice->histories()->create([
                    'status' => DB::raw('status'),
                    'description' => "${estimate_number} updated!"
                ]);
            });
        } catch (\Throwable $th) {
            return $th->getMessage();
        }

        return true;
    }

}