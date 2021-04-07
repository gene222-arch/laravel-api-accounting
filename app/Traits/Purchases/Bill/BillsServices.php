<?php

namespace App\Traits\Purchases\Bill;

use App\Models\Bill;
use App\Models\Stock;
use App\Models\Vendor;
use Illuminate\Support\Facades\DB;
use App\Jobs\QueueBillNotification;
use App\Traits\Banking\Transaction\HasTransaction;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

trait BillsServices
{
    use HasTransaction;
    
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
     * @param  array $items
     * @param  array $paymentDetail
     * @return mixed
     */
    public function createBill (int $vendorId, string $billNumber, int $orderNo, string $date, string $dueDate, array $items, array $paymentDetail): mixed
    {
        try {
            DB::transaction(function () use ($vendorId, $billNumber, $orderNo, $date, $dueDate, $items, $paymentDetail)
            {
                $bill = Bill::create([
                    'vendor_id' => $vendorId,
                    'bill_number' => $billNumber,
                    'order_no' => $orderNo,
                    'date' => $date,
                    'due_date' => $dueDate
                ]);

                $bill->items()->attach($items);

                $bill->paymentDetail()->create($paymentDetail);

                (new Stock())->stockOut($items);
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

                $bill
                    ->payments()
                    ->create([
                        'account_id' => $accountId,
                        'currency_id' => $currencyId,
                        'payment_method_id' => $paymentMethodId,
                        'expense_category_id' => $expenseCategoryId,
                        'date' => Carbon::now(),
                        'amount' => $amount,
                        'description' => $description,
                        'reference' => $reference
                    ]);

                $this->updateStatus($bill);
                
                /** Transactions */
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
                $bill = Bill::find($id);

                $bill->paymentDetail()
                    ->update([
                        'amount_due' => DB::raw('amount_due - ' . $amount)
                    ]);
                        
                $bill
                    ->payments()
                    ->create([
                        'account_id' => $accountId,
                        'currency_id' => $currencyId,
                        'payment_method_id' => $paymentMethodId,
                        'expense_category_id' => $expenseCategoryId,
                        'date' => $date,
                        'amount' => $amount,
                        'description' => $description,
                        'reference' => $reference
                    ]);

                $this->updateStatus($bill, $bill->paymentDetail->amount_due);
                
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
     * @param  array $items
     * @param  array $paymentDetail
     * @return mixed
     */
    public function updateBill (int $id, int $vendorId, string $billNumber, int $orderNo, string $date, string $dueDate, array $items, array $paymentDetail): mixed
    {
        try {
            DB::transaction(function () use ($id, $vendorId, $billNumber, $orderNo, $date, $dueDate, $items, $paymentDetail)
            {
                $bill = Bill::find($id);

                $bill->update([
                    'customer_id' => $vendorId,
                    'bill_number' => $billNumber,
                    'order_no' => $orderNo,
                    'date' => $date,
                    'due_date' => $dueDate
                ]);

                $bill->items()->sync($items);

                $bill->paymentDetail()->update($paymentDetail);
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
     * @return boolean
     */
    public function updateStatus (Bill $bill, float $amountDue = 0, string $status = null): bool
    {
        $status ??= !$amountDue ? 'Paid' : 'Partially Paid';

        return $bill->update([
            'status' => $status
        ]);
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
     * @return boolean
     */
    public function cancelInvoice (Bill $bill): bool
    {
        return $this->updateStatus($bill, 0, 'Cancelled');
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