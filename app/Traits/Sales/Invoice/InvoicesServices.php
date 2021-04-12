<?php

namespace App\Traits\Sales\Invoice;

use Carbon\Carbon;
use App\Models\Stock;
use App\Models\Account;
use App\Models\Invoice;
use App\Models\Revenue;
use App\Models\Customer;
use App\Models\IncomeCategory;
use Illuminate\Support\Facades\DB;
use App\Jobs\QueueInvoiceNotification;
use Illuminate\Database\Eloquent\Collection;
use App\Traits\Banking\Transaction\HasTransaction;

trait InvoicesServices
{    
    use HasTransaction;
    
    /**
     * Create a new record of invoice
     *
     * @param  array $invoiceDetails
     * @param  string $invoice_number
     * @param  array $items
     * @param  array $payment_details
     * @return mixed
     */
    public function createInvoice (array $invoiceDetails, string $invoice_number, array $items, array $payment_details): mixed
    {
        try {
            DB::transaction(function () use ($invoiceDetails, $invoice_number, $items, $payment_details)
            {
                $invoice = Invoice::create($invoiceDetails);

                $invoice->items()->attach($items);

                $invoice->paymentDetail()->create($payment_details);

                (new Stock())->stockOut($items);

                $invoice
                    ->histories()
                    ->create([
                        'status' => 'Draft',
                        'description' => "${invoice_number} added!"
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
     * @param  Invoice $invoice
     * @param  array $invoiceDetails
     * @param  string $invoice_number
     * @param  array $items
     * @param  array $payment_details
     * @return mixed
     */
    public function updateInvoice (Invoice $invoice, array $invoiceDetails, string $invoice_number, array $items, array $payment_details): mixed
    {
        try {
            DB::transaction(function () use ($invoice, $invoiceDetails, $invoice_number, $items, $payment_details)
            {
                $invoice->update($invoiceDetails);

                $invoice->items()->sync($items);

                $invoice->paymentDetail()->update($payment_details);

                $invoice
                    ->histories()
                    ->create([
                        'status' => 'Draft',
                        'description' => "$invoice_number updated"
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
     * @param  integer $account_id
     * @param  integer $payment_method_id
     * @param  string $date
     * @param  float $amount
     * @param  string|null $description
     * @param  string|null $reference
     * @return mixed
     */
    public function markAsPaid (Invoice $invoice, int $account_id, int $payment_method_id, float $amount, ?string $description, ?string $reference): mixed
    {
        try {
            DB::transaction(function () use ($invoice, $account_id, $payment_method_id, $amount, $description, $reference) 
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
                $revenue = Revenue::create([
                    'number' => $invoice->invoice_number,
                    'account_id' => $account_id,
                    'customer_id' => $invoice->customer_id,
                    'income_category_id' => $invoice->income_category_id,
                    'payment_method_id' => $payment_method_id,
                    'currency_id' => $invoice->currency_id,
                    'date' => Carbon::now(),
                    'amount' => $amount,
                    'description' => $description,
                    'recurring' => $invoice->recurring,
                    'reference' => $reference,
                    'file' => null
                ]);

                $revenue->invoices()->attach($invoice);

                /** Transactions */
                $this->createTransaction(
                    get_class($invoice),
                    $invoice->id,
                    $invoice->invoice_number,
                    $account_id,
                    $invoice->income_category_id,
                    null,
                    $payment_method_id,
                    IncomeCategory::find($invoice->income_category_id)->name,
                    'Income',
                    $amount,
                    $amount,
                    0.00,
                    $description,
                    Customer::find($invoice->customer_id)->name
                );

                /** Account */
                Account::where('id', $account_id)
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
     * @param  Invoice $invoice
     * @param  integer $account_id
     * @param  integer $payment_method_id
     * @param  string $date
     * @param  float $amount
     * @param  string|null $description
     * @param  string|null $reference
     * @return mixed
     */
    public function payment (Invoice $invoice, int $account_id, int $payment_method_id, string $date, float $amount, ?string $description, ?string $reference): mixed
    {
        try {
            DB::transaction(function () use ($invoice, $account_id, $payment_method_id, $date, $amount, $description, $reference) 
            {
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
                $revenue = Revenue::create([
                    'number' => $invoice->invoice_number,
                    'account_id' => $account_id,
                    'customer_id' => $invoice->customer_id,
                    'income_category_id' => $invoice->income_category_id,
                    'payment_method_id' => $payment_method_id,
                    'currency_id' => $invoice->currency_id,
                    'date' => $date,
                    'amount' => $amount,
                    'description' => $description,
                    'recurring' => $invoice->recurring,
                    'reference' => $reference,
                    'file' => null
                ]);

                $revenue->invoices()->attach($invoice);

                /** Transactions */
                $this->createTransaction(
                    get_class($invoice),
                    $invoice->id,
                    $invoice->invoice_number,
                    $account_id,
                    $invoice->income_category_id,
                    null,
                    $payment_method_id,
                    IncomeCategory::find($invoice->income_category_id)->name,
                    'Income',
                    $amount,
                    $amount,
                    0.00,
                    $description,
                    Customer::find($invoice->customer_id)->name
                );

                /** Account */
                Account::where('id', $account_id)
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

}