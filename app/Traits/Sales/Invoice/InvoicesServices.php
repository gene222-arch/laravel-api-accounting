<?php

namespace App\Traits\Sales\Invoice;

use Carbon\Carbon;
use App\Models\Stock;
use App\Models\Account;
use App\Models\Invoice;
use App\Models\Customer;
use App\Models\IncomeCategory;
use Illuminate\Support\Facades\DB;
use App\Jobs\QueueInvoiceNotification;
use Illuminate\Database\Eloquent\Collection;
use App\Traits\Sales\Revenue\RevenuesServices;
use App\Traits\Banking\Transaction\HasTransaction;

trait InvoicesServices
{    
    use HasTransaction, RevenuesServices;

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
     * @param  string $recurring
     * @param  array $items
     * @param  array $paymentDetails
     * @return mixed
     */
    public function createInvoice (int $customerId, string $invoiceNumber, int $orderNo, string $date, string $dueDate, string $recurring, array $items, array $paymentDetails): mixed
    {
        try {
            DB::transaction(function () use ($customerId, $invoiceNumber, $orderNo, $date, $dueDate, $recurring, $items, $paymentDetails)
            {
                $invoice = Invoice::create([
                    'customer_id' => $customerId,
                    'invoice_number' => $invoiceNumber,
                    'order_no' => $orderNo,
                    'date' => $date,
                    'due_date' => $dueDate,
                    'recurring' => $recurring
                ]);

                $invoice->items()->attach($items);

                $invoice->paymentDetail()->create($paymentDetails);

                (new Stock())->stockOut($items);

                $invoice
                    ->histories()
                    ->create([
                        'status' => 'Draft',
                        'description' => "${invoiceNumber} added!"
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
     * @param  string $recurring
     * @param  array $items
     * @param  array $paymentDetails
     * @return mixed
     */
    public function updateInvoice (int $id, int $customerId, string $invoiceNumber, int $orderNo, string $date, string $dueDate, string $recurring, array $items, array $paymentDetails): mixed
    {
        try {
            DB::transaction(function () use ($id, $customerId, $invoiceNumber, $orderNo, $date, $dueDate, $recurring, $items, $paymentDetails)
            {
                $invoice = Invoice::find($id);

                $invoice->update([
                    'customer_id' => $customerId,
                    'invoice_number' => $invoiceNumber,
                    'order_no' => $orderNo,
                    'date' => $date,
                    'due_date' => $dueDate,
                    'recurring' => $recurring
                ]);

                $invoice->items()->sync($items);

                $invoice->paymentDetail()->update($paymentDetails);

                $invoice
                    ->histories()
                    ->create([
                        'status' => 'Draft',
                        'description' => "$invoiceNumber updated"
                    ]);
            });
        } catch (\Throwable $th) {
            return $th->getMessage();
        }

        return true;
    }    
    
    /**
     * Update an existing invoice record's status
     *
     * @param  Invoice $invoice
     * @param  float $amountDue
     * @param  string $status
     * @return string
     */
    public function updateStatus(Invoice $invoice, float $amountDue = 0, string $status = null): string
    {
        $status ??= !$amountDue ? 'Paid' : 'Partially Paid';

        $invoice->update([
            'status' => $status
        ]);

        return $status;
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
     * @return mixed
     */
    public function mail (Invoice $invoice, Customer $customer, ?string $subject, ?string $greeting, ?string $note, ?string $footer): mixed
    {
        try {
            DB::transaction(function () use ($invoice, $customer, $subject, $greeting, $note, $footer)
            {
                $isCreated = $invoice
                    ->histories()
                    ->create([
                        'status' => 'Mailed',
                        'description' => "Invoice marked as sent!"
                    ]);

                if ($isCreated)
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
            });
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
        
        return true;
    }

    /**
     * Mark an invoice record as paid via id
     *
     * @param  Invoice $invoice
     * @param  integer $accountId
     * @param  integer $currencyId
     * @param  integer $paymentMethodId
     * @param  integer $incomeCategoryId
     * @param  string $date
     * @param  float $amount
     * @param  string|null $description
     * @param  string|null $reference
     * @return mixed
     */
    public function markAsPaid (Invoice $invoice, int $accountId, int $currencyId, int $paymentMethodId, int $incomeCategoryId, float $amount, ?string $description, ?string $reference): mixed
    {
        try {
            DB::transaction(function () use (
                $invoice, $accountId, $currencyId, $paymentMethodId, $incomeCategoryId, 
                $amount, $description, $reference
            ) 
            {
                /** Invoice payment detail */
                $invoice->paymentDetail()
                    ->update([
                        'amount_due' => DB::raw("amount_due - ${amount}")
                    ]);

                /** Invoice status */
                $status = $this->updateStatus($invoice);

                /** Invoice action histories */
                $invoice
                    ->histories()
                    ->create([
                        'status' => $status,
                        'description' => "$amount Payment"
                    ]);

                /** Revenue */
                $this->createRevenue(
                    $invoice->invoice_number,
                    Carbon::now(),
                    $amount,
                    $description,
                    $invoice->recurring,
                    $reference,
                    null,
                    $accountId,
                    $invoice->customer_id,
                    $incomeCategoryId,
                    $paymentMethodId,
                    $currencyId
                );

                /** Transactions */
                $this->createTransaction(
                    get_class($invoice),
                    $invoice->id,
                    $accountId,
                    $incomeCategoryId,
                    null,
                    IncomeCategory::find($incomeCategoryId)->name,
                    'Income',
                    $amount,
                    $amount,
                    0.00,
                    $description,
                    Customer::find($invoice->customer_id)->name
                );

                /** Account */
                Account::where('id', $accountId)
                    ->update([
                        'balance' => DB::raw("balance - ${amount}")
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
     * @param  integer $incomeCategoryId
     * @param  string $date
     * @param  float $amount
     * @param  string|null $description
     * @param  string|null $reference
     * @return mixed
     */
    public function payment (int $id, int $accountId, int $currencyId, int $paymentMethodId, int $incomeCategoryId, string $date, float $amount, ?string $description, ?string $reference): mixed
    {
        try {
            DB::transaction(function () use (
                $id, $accountId, $currencyId, $paymentMethodId, $incomeCategoryId,
                $date, $amount, $description, $reference) 
            {
                /** Invoice */
                $invoice = Invoice::find($id);

                /** Invoice payment detail */
                $invoice->paymentDetail()
                    ->update([
                        'amount_due' => DB::raw('amount_due - ' . $amount)
                    ]);

                /** Invoice status */
                $status = $this->updateStatus($invoice, $invoice->paymentDetail->amount_due);

                /** Invoice action histories */
                $invoice
                    ->histories()
                    ->create([
                        'status' => $status,
                        'description' => "$amount Payment"
                    ]);
                
                /** Revenue */
                $this->createRevenue(
                    $invoice->invoice_number,
                    $date,
                    $amount,
                    $description,
                    $invoice->recurring,
                    $reference,
                    null,
                    $accountId,
                    $invoice->customer_id,
                    $incomeCategoryId,
                    $paymentMethodId,
                    $currencyId
                );

                /** Transactions */
                $this->createTransaction(
                    get_class($invoice),
                    $id,
                    $accountId,
                    $incomeCategoryId,
                    null,
                    IncomeCategory::find($incomeCategoryId)->name,
                    'Income',
                    $amount,
                    $amount,
                    0.00,
                    $description,
                    Customer::find($invoice->customer_id)->name
                );

                /** Account */
                Account::where('id', $accountId)
                    ->update([
                        'balance' => DB::raw("balance - ${amount}")
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
     * @return void
     */
    public function cancelInvoice (Invoice $invoice): void
    {
        $status = $this->updateStatus($invoice, 0, 'Cancelled');

        $invoice
            ->histories()
            ->create([
                'status' => $status,
                'description' => 'Invoice marked as cancelled!'
            ]);
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