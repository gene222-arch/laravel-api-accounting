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
        return Invoice::with('paymentDetail')
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
                'items' => fn($q) => $q->select('name'),
                'paymentDetail'
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

                $invoice->items()->attach($items);

                $invoice->paymentDetail()->create($paymentDetails);

                (new Stock())->stockOut($items);
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

                $invoice->items()->sync($items);

                $invoice->paymentDetail()->update($paymentDetails);

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
     * @param  integer $accountId
     * @param  integer $currencyId
     * @param  integer $paymentMethodId
     * @param  string $date
     * @param  float $amount
     * @param  string|null $description
     * @param  string|null $reference
     * @return mixed
     */
    public function markAsPaid (int $id, int $accountId, int $currencyId, int $paymentMethodId, string $date, float $amount, ?string $description, ?string $reference): mixed
    {
        try {
            DB::transaction(function () use ($id, $accountId, $currencyId, $paymentMethodId, $date, $amount, $description, $reference) 
            {
                $invoice = Invoice::find($id);

                $invoice->paymentDetail()
                    ->update([
                        'amount_due' => 0.00
                    ]);

                $invoice
                    ->payments()
                    ->create([
                        'account_id' => $accountId,
                        'currency_id' => $currencyId,
                        'payment_method_id' => $paymentMethodId,
                        'date' => $date,
                        'amount' => $amount,
                        'description' => $description,
                        'reference' => $reference
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
     * @param  integer $accountId
     * @param  integer $currencyId
     * @param  integer $paymentMethodId
     * @param  string $date
     * @param  float $amount
     * @param  string|null $description
     * @param  string|null $reference
     * @return mixed
     */
    public function payment (int $id, int $accountId, int $currencyId, int $paymentMethodId, string $date, float $amount, ?string $description, ?string $reference): mixed
    {
        try {
            DB::transaction(function () use (
                $id, $accountId, $currencyId, $paymentMethodId, 
                $date, $amount, $description, $reference) 
            {
                $invoice = Invoice::find($id);

                $invoice->paymentDetail()
                    ->update([
                        'amount_due' => DB::raw('amount_due - ' . $amount)
                    ]);
                        
                $invoice
                    ->payments()
                    ->create([
                        'account_id' => $accountId,
                        'currency_id' => $currencyId,
                        'payment_method_id' => $paymentMethodId,
                        'date' => $date,
                        'amount' => $amount,
                        'description' => $description,
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
     * Update an invoice status as cancelled
     *
     * @param  Invoice $invoice
     * @return boolean
     */
    public function cancelInvoice (Invoice $invoice): bool
    {
        $update = $invoice->update([
                'status' => 'Cancelled'
            ]);

        return boolval($update);
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