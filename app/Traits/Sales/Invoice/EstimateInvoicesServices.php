<?php

namespace App\Traits\Sales\Invoice;

use App\Jobs\QueueEstimateInvoiceNotification;
use App\Models\Customer;
use App\Models\DefaultSetting;
use App\Models\EstimateInvoice;
use App\Models\Invoice;
use App\Traits\Reports\Accounting\TaxSummaryServices;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;

trait EstimateInvoicesServices
{
    use TaxSummaryServices;

    /**
     * Create a new record of estimated invoice
     *
     * @param  array $estimateInvoiceDetails
     * @param  string $estimate_number
     * @param  array $items
     * @param  array $payment_details
     * @return mixed
     */
    public function createEstimateInvoice (array $estimateInvoiceDetails, string $estimate_number, array $items, array $payment_details): mixed
    {
        try {
            DB::transaction(function () use ($estimateInvoiceDetails, $estimate_number, $items, $payment_details)
            {
                $estimateInvoice = EstimateInvoice::create($estimateInvoiceDetails);

                $estimateInvoice->items()->attach($items);

                $estimateInvoice->paymentDetail()->create($payment_details);

                $this->createManyTaxSummary(
                    get_class($estimateInvoice),
                    $estimateInvoice->id,
                    'Sales',
                    $items
                );

                $estimateInvoice->histories()->create([
                    'description' => "${estimate_number} added!"
                ]);
            });
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
        return true;
    }

        
    /**
     * Convert the estimate to invoice
     *
     * @param  App\Models\EstimateInvoice $estimateInvoice
     * @param  string $invoiceNumber
     * @param  integer $orderNo
     * @param  string $date
     * @param  string $dueDate
     * @return mixed
     */
    public function toInvoice (EstimateInvoice $estimateInvoice, string $invoiceNumber, int $orderNo, string $date, string $dueDate): mixed
    {
        try {
            DB::transaction(function () use ($estimateInvoice, $invoiceNumber, $orderNo, $date, $dueDate)
            {   
                $defaultSettings = DefaultSetting::first();

                $invoice = Invoice::create([
                    'customer_id' => $estimateInvoice->customer_id,
                    'currency_id' => $estimateInvoice->currency_id,
                    'income_category_id' => $defaultSettings->income_category_id,
                    'invoice_number' => $invoiceNumber,
                    'order_no' => $orderNo,
                    'date' => $date,
                    'due_date' => $dueDate
                ]);

                $estimateInvoiceItems = $estimateInvoice->items
                    ->map
                    ->pivot
                    ->map(function ($item) {
                        unset($item['estimate_invoice_id']);

                        return $item;
                    })
                    ->toArray();

                $invoice->items()->attach($estimateInvoiceItems);

                $invoice->paymentDetail()->create($estimateInvoice->paymentDetail->toArray());

                $this->createManyTaxSummary(
                    get_class($estimateInvoice),
                    $estimateInvoice->id,
                    'Sales',
                    $estimateInvoiceItems
                );

                $estimateInvoice->histories()->create([
                    'status' => 'invoiced',
                    'description' => "{$estimateInvoice->estimate_number} INVOICED!"
                ]);

                $invoice->histories()->create([
                    'description' => "${invoiceNumber} added!"
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
     * @param  EstimateInvoice $estimateInvoice
     * @param  Customer $customer
     * @param  string $subject
     * @param  string $greeting
     * @param  string $note
     * @param  string $footer
     * @return mixed
     */
    public function mail(EstimateInvoice $estimateInvoice, Customer $customer, ?string $subject, ?string $greeting, ?string $note, ?string $footer): mixed
    {
        try {
            DB::transaction(function () use ($estimateInvoice, $customer, $subject, $greeting, $note, $footer)
            {
                $isCreated = $estimateInvoice->histories()
                    ->create([
                        'status' => 'Sent',
                        'description' => "Invoice marked as sent!"
                    ]);

                if ($isCreated)
                {
                    dispatch(new QueueEstimateInvoiceNotification(
                        $estimateInvoice, 
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
     * @param  EstimateInvoice $estimateInvoice
     * @return mixed
     */
    public function markAsApproved(EstimateInvoice $estimateInvoice): mixed
    {
        try {
            DB::transaction(function () use ($estimateInvoice)
            {
                $estimateInvoice->histories()->create([
                    'status' => 'Approved',
                    'description' => "{$estimateInvoice->estimate_number} marked as approved!"
                ]);

                $estimateInvoice->update([
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
     * @param  EstimateInvoice $estimateInvoice
     * @return mixed
     */
    public function markAsRefused(EstimateInvoice $estimateInvoice): mixed
    {
        try {
            DB::transaction(function () use ($estimateInvoice)
            {
                $estimateInvoice->histories()->create([
                    'status' => 'Refused',
                    'description' => "{$estimateInvoice->estimate_number} marked as refused!"
                ]);

                $estimateInvoice->update([
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
     * @param  EstimateInvoice $estimateInvoice
     * @param  array $estimateInvoiceDetails
     * @param  string $estimate_number
     * @param  array $items
     * @param  array $payment_details
     * @return mixed
     */
    public function updateEstimateInvoice (EstimateInvoice $estimateInvoice, array $estimateInvoiceDetails, string $estimate_number, array $items, array $payment_details): mixed
    {
        try {
            DB::transaction(function () use ($estimateInvoice, $estimateInvoiceDetails, $estimate_number, $items, $payment_details)
            {
                $estimateInvoice->update($estimateInvoiceDetails);

                $estimateInvoice->items()->sync($items);

                $estimateInvoice->paymentDetail()->update($payment_details);

                $this->updateManyTaxSummary(
                    get_class($estimateInvoice),
                    $estimateInvoice->id,
                    'Sales',
                    $items
                );

                $estimateInvoice->histories()->create([
                    'status' => DB::raw('status'),
                    'description' => "${estimate_number} updated!"
                ]);
            });
        } catch (\Throwable $th) {
            return $th->getMessage();
        }

        return true;
    }

    
    /**
     * Delete one or multiple records of estimate invoices
     *
     * @param  array $ids
     * @return mixed
     */
    public function deleteManyEstimateInvoices (array $ids): mixed 
    {
        try {
            DB::transaction(function () use ($ids)
            {
                EstimateInvoice::whereIn('id', $ids)->delete();
                
                $this->deleteManyTaxSummaries(
                    'App\Models\EstimateInvoice',
                    $ids
                );
            });
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
        
        return true;
    }
}