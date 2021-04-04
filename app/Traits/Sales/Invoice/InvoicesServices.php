<?php

namespace App\Traits\Sales\Invoice;

use App\Models\Invoice;
use App\Models\Payment;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;
use App\Jobs\QueueInvoiceNotification;
use App\Models\Stock;
use Illuminate\Database\Eloquent\Collection;

trait InvoicesServices
{    
    /**
     * Get all records of invoices
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllInvoices (): Collection
    {
        return Invoice::with('invoicePaymentDetail')
            ->latest()
            ->get();
    }
    
    /**
     * Get a record of invoice via id
     *
     * @param  int $id
     * @return Invoice
     */
    public function getInvoiceById (int $id): Invoice
    {
        return Invoice::find($id)
            ->with([
                'invoiceDetails' => fn($q) => $q->select('name'),
                'invoicePaymentDetail'
            ])
            ->first();
    }
    
    /**
     * Create a new record of invoice
     *
     * @param  integer $customerId
     * @param  string $invoiceNumber
     * @param  integer $orderNo
     * @param  string $date
     * @param  string $dueDate
     * @param  array $items
     * @param  array $paymentDetails
     * @return mixed
     */
    public function createInvoice (int $customerId, string $invoiceNumber, int $orderNo, string $date, string $dueDate, array $items, array $paymentDetails): mixed
    {
        try {
            DB::transaction(function () use ($customerId, $invoiceNumber, $orderNo, $date, $dueDate, $items, $paymentDetails)
            {
                $invoice = Invoice::create([
                    'customer_id' => $customerId,
                    'invoice_number' => $invoiceNumber,
                    'order_no' => $orderNo,
                    'date' => $date,
                    'due_date' => $dueDate
                ]);

                $invoice->invoiceDetails()->attach($items);

                $invoice->invoicePaymentDetail()->create($paymentDetails);

                (new Stock())->stockOut($items);
            });
        } catch (\Throwable $th) {
            return $th->getMessage();
        }

        return true;
    }
        
    /**
     * Send an email notification to the specified customer
     *
     * @param  Invoice $invoice
     * @param  Customer $customer
     * @param  string|null $subject
     * @param  string|null $greeting
     * @param  string|null $note
     * @param  string|null $footer
     * @return void
     */
    public function email (Invoice $invoice, Customer $customer, ?string $subject, ?string $greeting, ?string $note, ?string $footer): void
    {
        dispatch(new QueueInvoiceNotification(
            $invoice, 
            $customer, 
            $subject, 
            $greeting, 
            $note, 
            $footer
        ))
        ->delay(now()->addSeconds(5));
    }

    /**
     * Mark an invoice record as paid via id
     *
     * @param integer $id
     * @param float $amount
     * @return mixed
     */
    public function markAsPaid (int $id, float $amount): mixed
    {
        try {
            DB::transaction(function () use ($id, $amount) 
            {
                $invoice = Invoice::find($id);

                $invoice->invoicePaymentDetail()
                    ->update([
                        'amount_due' => 0.00
                    ]);

                $invoice
                    ->payments()
                    ->create([
                        'model_type' => get_class($invoice),
                        'date' => now(),
                        'amount' => $amount,
                        'account' => 'Cash',
                        'currency' => 'US Dollar',
                        'payment_method' => 'Cash',
                    ]);

                $invoice->update([
                    'status' => 'Paid'
                ]);
                
            });
        } catch (\Throwable $th) {
            return $th->getMessage();
        }

        return true;
    }
    
    /**
     * Create a new record of invoice payment
     *
     * @param  integer $id
     * @param  string $date
     * @param  float $amount
     * @param  string $account
     * @param  string $currency
     * @param  string|null $description
     * @param  string $paymentMethod
     * @param  string|null $reference
     * @return mixed
     */
    public function payment (int $id, string $date, float $amount, string $account, string $currency, ?string $description, string $paymentMethod, ?string $reference): mixed
    {
        try {
            DB::transaction(function () use ($id, $date, $amount, $account, $currency, $description, $paymentMethod, $reference) 
            {
                $invoice = Invoice::find($id);

                $invoice->invoicePaymentDetail()
                    ->update([
                        'amount_due' => DB::raw('amount_due - ' . $amount)
                    ]);

                $invoice
                    ->payments()
                    ->create([
                        'model_type' => get_class($invoice),
                        'date' => $date,
                        'amount' => $amount,
                        'account' => $account,
                        'currency' => $currency,
                        'description' => $description,
                        'payment_method' => $paymentMethod,
                        'reference' => $reference
                    ]);

                $invoice->update([
                    'status' => 'Partially paid'
                ]);
                
            });
        } catch (\Throwable $th) {
            return $th->getMessage();
        }

        return true;
    }
 
    /**
     * Update an existing record of invoice
     *
     * @param  integer $id
     * @param  integer $customerId
     * @param  string $invoiceNumber
     * @param  integer $orderNo
     * @param  string $date
     * @param  string $dueDate
     * @param  array $items
     * @param  array $paymentDetails
     * @return mixed
     */
    public function updateInvoice (int $id, int $customerId, string $invoiceNumber, int $orderNo, string $date, string $dueDate, array $items, array $paymentDetails): mixed
    {
        try {
            DB::transaction(function () use ($id, $customerId, $invoiceNumber, $orderNo, $date, $dueDate, $items, $paymentDetails)
            {
                $invoice = Invoice::find($id);

                $invoice->update([
                    'customer_id' => $customerId,
                    'invoice_number' => $invoiceNumber,
                    'order_no' => $orderNo,
                    'date' => $date,
                    'due_date' => $dueDate
                ]);

                $invoice->invoiceDetails()->sync($items);

                $invoice->invoicePaymentDetail()->update($paymentDetails);
            });
        } catch (\Throwable $th) {
            return $th->getMessage();
        }

        return true;
    }    

    /**
     * Delete one or multiple records of invoices
     *
     * @param  mixed $ids
     * @return boolean
     */
    public function deleteInvoices (array $ids): bool
    {
        return Invoice::whereIn('id', $ids)->delete();
    }

}