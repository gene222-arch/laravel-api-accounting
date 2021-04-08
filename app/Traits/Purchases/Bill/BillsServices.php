<?php

namespace App\Traits\Purchases\Bill;

use App\Models\Bill;
use App\Models\Stock;
use App\Models\Vendor;
use Illuminate\Support\Facades\DB;
use App\Jobs\QueueBillNotification;
use App\Models\Account;
use App\Models\ExpenseCategory;
use App\Traits\Banking\Transaction\HasTransaction;
use App\Traits\Purchases\Payment\PaymentsServices;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

trait BillsServices
{
    use HasTransaction, PaymentsServices;
    
    /**
     * Get latest records of Bills
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllBills (): Collection
    {
        return Bill::with('paymentDetail')
            ->latest()
            ->get();
    }
    
    /**
     * Get a record of bill via id
     *
     * @param  int $id
     * @return Bill|null
     */
    public function getBillById (int $id): Bill|null
    {
        return Bill::find($id)
            ->with([
                'items' => fn($q) => $q->select('name'),
                'paymentDetail'
            ])
            ->first();
    }
    

    /**
     * Create a new record of bill
     *
     * @param  integer $vendorId
     * @param  string $billNumber
     * @param  integer $orderNo
     * @param  string $date
     * @param  string $dueDate
     * @param  string $recurring
     * @param  array $items
     * @param  array $paymentDetail
     * @return mixed
     */
    public function createBill (int $vendorId, string $billNumber, int $orderNo, string $date, string $dueDate, string $recurring, array $items, array $paymentDetail): mixed
    {
        try {
            DB::transaction(function () use ($vendorId, $billNumber, $orderNo, $date, $dueDate, $recurring, $items, $paymentDetail)
            {
                $bill = Bill::create([
                    'vendor_id' => $vendorId,
                    'bill_number' => $billNumber,
                    'order_no' => $orderNo,
                    'date' => $date,
                    'due_date' => $dueDate,
                    'recurring' => $recurring
                ]);

                $bill->items()->attach($items);

                $bill->paymentDetail()->create($paymentDetail);

                (new Stock())->stockOut($items);

                $bill
                    ->histories()
                    ->create([
                        'status' => 'Draft',
                        'description' => "${billNumber} added!"
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
     * @param  integer $id
     * @param  integer $accountId
     * @param  integer $currencyId
     * @param  integer $paymentMethodId
     * @param  integer $expenseCategoryId
     * @param  string $date
     * @param  float $amount
     * @param  string|null $description
     * @param  string|null $reference
     * @return mixed
     */
    public function markAsPaid (int $id, int $accountId, int $currencyId, int $paymentMethodId, int $expenseCategoryId, float $amount, ?string $description, ?string $reference): mixed
    {
        try {
            DB::transaction(function () use (
                $id, $accountId, $currencyId, $paymentMethodId, $expenseCategoryId, 
                $amount, $description, $reference
            ) 
            {
                $bill = Bill::find($id);

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
        

                $this->createPayment(
                    $bill->bill_number,
                    $accountId,
                    $bill->vendor_id,
                    $expenseCategoryId,
                    $paymentMethodId,
                    $currencyId,
                    Carbon::now(),
                    $amount,
                    $description,
                    $bill->recurring,
                    $reference,
                    null
                );

                /** Transactions */
                $this->createTransaction(
                    get_class($bill),
                    $id,
                    $accountId,
                    null,
                    $expenseCategoryId,
                    ExpenseCategory::find($expenseCategoryId)->name,
                    'Expense',
                    $amount,
                    0.00,
                    $amount,
                    $description,
                    Vendor::find($bill->vendor_id)->name
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
     * Create a new record of bill payment
     *
     * @param  integer $id
     * @param  integer $accountId
     * @param  integer $currencyId
     * @param  integer $paymentMethodId
     * @param  integer $expenseCategoryId
     * @param  string $date
     * @param  float $amount
     * @param  string|null $description
     * @param  string|null $reference
     * @return mixed
     */
    public function payment (int $id, int $accountId, int $currencyId, int $paymentMethodId, int $expenseCategoryId, string $date, float $amount, ?string $description, ?string $reference): mixed
    {
        try {
            DB::transaction(function () use (
                $id, $accountId, $currencyId, $paymentMethodId, $expenseCategoryId, 

                $date, $amount, $description, $reference) 
            {
                /** Bill */
                $bill = Bill::find($id);

                /** Bill payment detail */
                $bill->paymentDetail()
                    ->update([
                        'amount_due' => DB::raw("amount_due - ${amount}")
                    ]);

                /** Bill status */
                $status = $this->updateStatus($bill, $bill->paymentDetail->amount_due);    

                /** Bill histories */
                $bill
                    ->histories()
                    ->create([
                        'status' => $status,
                        'description' => "${amount} Payment"
                    ]);

                /** Purchases */
                $this->createPayment(
                    $bill->bill_number,
                    $accountId,
                    $bill->vendor_id,
                    $expenseCategoryId,
                    $paymentMethodId,
                    $currencyId,
                    $date,
                    $amount,
                    $description,
                    $bill->recurring,
                    $reference,
                    null
                );
                
                /** Transactions */
                $this->createTransaction(
                    get_class($bill),
                    $id,
                    $accountId,
                    null,
                    $expenseCategoryId,
                    ExpenseCategory::find($expenseCategoryId)->name,
                    'Expense',
                    $amount,
                    0.00,
                    $amount,
                    $description,
                    Vendor::find($bill->vendor_id)->name
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
     * Update an existing record of bill
     *
     * @param  integer $id
     * @param  integer $vendorId
     * @param  string $billNumber
     * @param  integer $orderNo
     * @param  string $date
     * @param  string $dueDate
     * @param  string $recurring
     * @param  array $items
     * @param  array $paymentDetail
     * @return mixed
     */
    public function updateBill (int $id, int $vendorId, string $billNumber, int $orderNo, string $date, string $dueDate, string $recurring, array $items, array $paymentDetail): mixed
    {
        try {
            DB::transaction(function () use ($id, $vendorId, $billNumber, $orderNo, $date, $dueDate, $recurring, $items, $paymentDetail)
            {
                $bill = Bill::find($id);

                $bill->update([
                    'customer_id' => $vendorId,
                    'bill_number' => $billNumber,
                    'order_no' => $orderNo,
                    'date' => $date,
                    'due_date' => $dueDate,
                    'recurring' => $recurring
                ]);

                $bill->items()->sync($items);

                $bill->paymentDetail()->update($paymentDetail);

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
     * @return void
     */
    public function email (Bill $bill, Vendor $vendor, ?string $subject, ?string $greeting, ?string $note, ?string $footer): void
    {
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
    }

    /**
     * Update a bill status as cancelled
     *
     * @param  Bill $bill
     * @return void
     */
    public function cancelBill (Bill $bill): void
    {
        $status = $this->updateStatus($bill, 0, 'Cancelled');

        $bill
            ->histories()
            ->create([
                'status' => $status,
                'description' => "Bill marked as cancelled!"
            ]);
    }

    /**
     * Delete one or multiple records of Bills
     *
     * @param  array $ids
     * @return boolean
     */
    public function deleteBills (array $ids): bool
    {
        return Bill::whereIn('id', $ids)->delete();
    }
}