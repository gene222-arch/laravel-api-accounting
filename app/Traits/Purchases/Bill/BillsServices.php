<?php

namespace App\Traits\Purchases\Bill;

use App\Models\Bill;
use App\Models\Stock;
use App\Models\Vendor;
use Illuminate\Support\Facades\DB;
use App\Jobs\QueueBillNotification;
use App\Models\Account;
use App\Models\ExpenseCategory;
use App\Models\Payment;
use App\Traits\Banking\Transaction\HasTransaction;
use App\Traits\Reports\Accounting\TaxSummaryServices;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

trait BillsServices
{
    use HasTransaction, TaxSummaryServices;

    /**
     * Create a new record of bill
     *
     * @param  array $bill_details
     * @param  string $bill_number
     * @param  array $items
     * @param  array $payment_details
     * @return mixed
     */
    public function createBill (array $bill_details, string $bill_number, array $items, array $payment_details): mixed
    {
        try {
            DB::transaction(function () use ($bill_details, $bill_number, $items, $payment_details)
            {
                $bill = Bill::create($bill_details);

                $bill->items()->attach($items);

                $bill->paymentDetail()->create($payment_details);

                (new Stock())->incomingStock($items);

                $this->createManyTaxSummary(
                    get_class($bill),
                    $bill->id,
                    'Purchase',
                    $items
                );

                $bill
                    ->histories()
                    ->create([
                        'status' => 'Draft',
                        'description' => "${bill_number} added!"
                    ]);
            });
        } catch (\Throwable $th) {
            return $th->getMessage();
        }

        return true;
    }
    
    /**
     * Mark a bill record as paid via id
     *
     * @param  Bill $bill
     * @param  integer $account_id
     * @param  integer $currency_id
     * @param  integer $payment_method_id
     * @param  integer $expense_category_id
     * @param  string $date
     * @param  float $amount
     * @param  string|null $description
     * @param  string|null $reference
     * @return mixed
     */
    public function markAsPaid (Bill $bill, int $account_id, int $currency_id, int $payment_method_id, int $expense_category_id, float $amount, ?string $description, ?string $reference): mixed
    {
        try {
            DB::transaction(function () use (
                $bill, $account_id, $currency_id, $payment_method_id, $expense_category_id, 
                $amount, $description, $reference
            ) 
            {
                $bill->paymentDetail()
                    ->update([
                        'amount_due' => 0.00
                    ]);

                $status = $this->updateStatus($bill);

                $bill
                    ->histories()
                    ->create([
                        'status' => $status,
                        'description' => "${amount} Payment!"
                    ]);
        
                /** Purchases */
                (new Payment())->create([
                    'number' => $bill->bill_number,
                    'account_id' => $account_id,
                    'vendor_id' => $bill->vendor_id,
                    'expense_category_id' => $expense_category_id,
                    'payment_method_id' => $payment_method_id,
                    'currency_id' => $currency_id,
                    'date' => Carbon::now(),
                    'amount' => $amount,
                    'description' => $description,
                    'recurring' => $bill->recurring,
                    'reference' => $reference,
                    'file' => null,
                ]);

                /** Transactions */
                $this->createTransaction(
                get_class($bill),
                $bill->id,
                $bill->bill_number,
                $account_id,
                null,
                $expense_category_id,
                $payment_method_id,
                ExpenseCategory::find($expense_category_id)->name,
                'Expense',
                $amount,
                $amount,
                0.00,
                $description,
                Vendor::find($bill->vendor_id)->name
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
     * Mark a bill as received
     *
     * @param  App\Models\Bill $bill
     * @return mixed
     */
    public function markAsReceived(Bill $bill): mixed
    {
        try {
            DB::transaction(function () use ($bill)
            {
                $bill->update([
                    'status' => 'Received'
                ]);

                (new Stock())->receiveIncomingStock($bill->items->map->details->toArray());
            });
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
        
        return true;
    }

    /**
     * Create a new record of bill payment
     *
     * @param  Bill $bill
     * @param  integer $account_id
     * @param  integer $currency_id
     * @param  integer $payment_method_id
     * @param  integer $expense_category_id
     * @param  string $date
     * @param  float $amount
     * @param  string|null $description
     * @param  string|null $reference
     * @return mixed
     */
    public function payment (Bill $bill, int $account_id, int $currency_id, int $payment_method_id, string $date, float $amount, ?string $description, ?string $reference): mixed
    {
        try {
            DB::transaction(function () use (
                $bill, $account_id, $currency_id, $payment_method_id, 
                $date, $amount, $description, $reference) 
            {
                /** Bill payment detail */
                $bill->paymentDetail()
                    ->update([
                        'amount_due' => DB::raw("amount_due - ${amount}")
                    ]);

                /** Bill status */
                $status = $this->updateStatus($bill, $bill->paymentDetail->amount_due);    

                /** Bill histories */
                $bill->histories()
                    ->create([
                        'status' => $status,
                        'description' => "${amount} Payment"
                    ]);

                /** Purchases */
                (new Payment())->create([
                    'number' => $bill->bill_number,
                    'account_id' => $account_id,
                    'vendor_id' => $bill->vendor_id,
                    'expense_category_id' => $bill->expense_category_id,
                    'payment_method_id' => $payment_method_id,
                    'currency_id' => $currency_id,
                    'date' => $date,
                    'amount' => $amount,
                    'description' => $description,
                    'recurring' => $bill->recurring,
                    'reference' => $reference,
                    'file' => null,
                ]);

                /** Transactions */
                $this->createTransaction(
                    get_class($bill),
                    $bill->id,
                    $bill->bill_number,
                    $account_id,
                    null,
                    $bill->expense_category_id,
                    $payment_method_id,
                    ExpenseCategory::find($bill->expense_category_id)->name,
                    'Expense',
                    $amount,
                    $amount,
                    0.00,
                    $description,
                    Vendor::find($bill->vendor_id)->name
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
     * Update an existing record of bill
     *
     * @param  Bill $bill
     * @param  integer $vendorId
     * @param  string $bill_number
     * @param  integer $orderNo
     * @param  string $date
     * @param  string $dueDate
     * @param  string $recurring
     * @param  array $items
     * @param  array $payment_details
     * @return mixed
     */
    public function updateBill (Bill $bill, $bill_details, array $items, array $payment_details): mixed
    {
        try {
            DB::transaction(function () use ($bill, $bill_details, $items, $payment_details)
            {
                $bill->update($bill_details);

                $bill->items()->sync($items);

                $bill->paymentDetail()->update($payment_details);

                $this->updateManyTaxSummary(
                    get_class($bill),
                    $bill->id,
                    'Purchase',
                    $items
                );

                $bill
                    ->histories()
                    ->create([
                        'status' => 'Draft',
                        'description' => "Bill updated!"
                    ]);
            });
        } catch (\Throwable $th) {
            return $th->getMessage();
        }

        return true;
    }    
    
    /**
     * Update an existing record of bill record's status
     *
     * @param  Bill $bill
     * @param  float $amountDue
     * @param  string $status
     * @return string
     */
    public function updateStatus (Bill $bill, float $amountDue = 0, string $status = null): string
    {
        $status ??= !$amountDue ? 'Paid' : 'Partially Paid';

        $bill->update([
            'status' => $status
        ]);

        return $status;
    }

    /**
     * Send an email notification to the specified vendor
     *
     * @param  Bill $bill
     * @param  Vendor $vendor
     * @param  string|null $subject
     * @param  string|null $greeting
     * @param  string|null $note
     * @param  string|null $footer
     * @return mixed
     */
    public function email (Bill $bill, Vendor $vendor, ?string $subject, ?string $greeting, ?string $note, ?string $footer): mixed
    {
        try {
            DB::transaction(function () use ($bill, $vendor, $subject, $greeting, $note, $footer)
            {
                $bill->update([
                    'status' => 'Sent'
                ]);
        
                $bill
                    ->histories()
                    ->create([
                        'status' => 'Sent',
                        'description' => "Bill has been sent!"
                    ]);
        
                dispatch(new QueueBillNotification(
                    $bill, 
                    $vendor, 
                    $subject, 
                    $greeting, 
                    $note, 
                    $footer
                ))
                ->delay(now()->addSeconds(5));
            });
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
        
        return true;
    }

    /**
     * Update a bill status as cancelled
     *
     * @param  Bill $bill
     * @return mixed
     */
    public function cancelBill (Bill $bill): mixed
    {
        try {
            DB::transaction(function () use ($bill)
            {
                $status = $this->updateStatus($bill, 0, 'Cancelled');

                $this->deleteManyTaxSummaries(
                    get_class($bill),
                    $bill->id
                );

                $bill
                    ->histories()
                    ->create([
                        'status' => $status,
                        'description' => "Bill marked as cancelled!"
                    ]);
            });
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
        
        return true;
    }

    /**
     * Delete one or multiple records of bills
     *
     * @param  array $ids
     * @return mixed
     */
    public function deleteManyBills(array $ids): mixed
    {
        try {
            DB::transaction(function () use ($ids)
            {
                Bill::whereIn('id', $ids)->delete();
                
                $this->deleteManyTaxSummaries(
                    'App\Models\Bill',
                    $ids
                );
            });
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
        
        return true;
    }
}